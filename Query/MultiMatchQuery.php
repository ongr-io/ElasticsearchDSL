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

/**
 * Elasticsearch multi_match query class.
 */
class MultiMatchQuery implements BuilderInterface
{
    /**
     * @var string
     */
    private $query;

    /**
     * @var array
     */
    private $fields = [];

    /**
     * @param string $query
     * @param array  $fields
     */
    public function __construct($query, array $fields)
    {
        $this->query = $query;
        $this->fields = $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'multi_match';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'query' => $this->query,
            'fields' => $this->fields,
        ];
    }
}
