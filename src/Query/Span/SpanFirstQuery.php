<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query\Span;

use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Elasticsearch span first query.
 */
class SpanFirstQuery implements SpanQueryInterface
{
    use ParametersTrait;

    /**
     * @var SpanQueryInterface
     */
    private $query;

    /**
     * @var int
     */
    private $end;

    /**
     * @param SpanQueryInterface $query
     * @param int                $end
     * @param array              $parameters
     *
     * @throws \LogicException
     */
    public function __construct(SpanQueryInterface $query, $end, array $parameters = [])
    {
        $this->query = $query;
        $this->end = $end;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'span_first';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [];
        $query['match'] = [$this->query->getType() => $this->query->toArray()];
        $query['end'] = $this->end;
        $output = $this->processArray($query);

        return $output;
    }
}
