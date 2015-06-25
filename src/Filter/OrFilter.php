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

/**
 * Represents Elasticsearch "or" filter.
 *
 * @link http://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-or-filter.html
 */
class OrFilter extends AndFilter
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'or';
    }
}
