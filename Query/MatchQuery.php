<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Query;

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;
use ONGR\ElasticsearchBundle\DSL\ParametersTrait;

/**
 * Elasticsearch match query class.
 */
class MatchQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $field;

    /**
     * @param string $query
     * @param string $field
     * @param array  $parameters
     */
    public function __construct($query, $field, array $parameters = [])
    {
        $this->query = $query;
        $this->field = $field;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'match';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            'query' => $this->query,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return $output;
    }
}
