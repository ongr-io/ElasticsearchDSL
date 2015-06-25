<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Filter;

use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Represents Elasticsearch "exists" filter.
 *
 * @link http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-exists-filter.html
 */
class ExistsFilter implements BuilderInterface
{
    /**
     * @var string
     */
    private $field;

    /**
     * @param string $field Field value.
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'exists';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'field' => $this->field,
        ];
    }
}
