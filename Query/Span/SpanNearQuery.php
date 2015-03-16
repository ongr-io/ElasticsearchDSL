<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Query\Span;

use ONGR\ElasticsearchBundle\DSL\ParametersTrait;

/**
 * Elasticsearch span near query.
 */
class SpanNearQuery implements SpanQueryInterface
{
    use ParametersTrait;

    /**
     * @var int
     */
    private $slop;

    /**
     * @var SpanQueryInterface[]
     */
    private $queries = [];

    /**
     * @param int                  $slop
     * @param SpanQueryInterface[] $queries
     * @param array                $parameters
     *
     * @throws \LogicException
     */
    public function __construct($slop, array $queries = [], array $parameters = [])
    {
        $this->slop = $slop;
        $this->queries = $queries;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'span_near';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [];
        foreach ($this->queries as $type) {
            $data = [$type->getType() => $type->toArray()];
            $query['clauses'][] = $data;
        }
        $query['slop'] = $this->slop;
        $output = $this->processArray($query);

        return $output;
    }
}
