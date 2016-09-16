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
 * Class representing Avg Aggregation.
 *
 * @link http://goo.gl/7KOIwo
 */
class AvgAggregation extends StatsAggregation
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'avg';
    }
}
