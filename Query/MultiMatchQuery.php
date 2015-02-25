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
     * @var array
     */
    private $fields = [];

    /**
     * @var string
     */
    private $query;

    /**
     * @param array  $fields
     * @param string $query
     */
    public function __construct(array $fields, $query)
    {
        $this->fields = $fields;
        $this->query = $query;
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
            'fields' => $this->fields,
            'query' => $this->query,
        ];
    }
}
