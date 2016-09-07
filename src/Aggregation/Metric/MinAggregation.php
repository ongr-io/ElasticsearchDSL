<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Metric;

/**
 * Class representing Min Aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-min-aggregation.html
 */
class MinAggregation extends StatsAggregation
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'min';
    }
}
