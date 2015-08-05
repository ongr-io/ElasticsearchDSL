<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\TopHitsAggregation;
use ONGR\ElasticsearchDSL\Sort\FieldSort;
use ONGR\ElasticsearchDSL\Sort\Sorts;

/**
 * Unit tests for top hits aggregation.
 */
class TopHitsAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Check if aggregation returns the expected array.
     */
    public function testToArray()
    {
        $sort = new FieldSort('acme');
        $aggregation = new TopHitsAggregation('acme', 0, 1, $sort);

        $expectedAgg = new \stdClass();
        $expectedAgg->size = 0;
        $expectedAgg->from = 1;
        $expectedAgg->sort = $sort->toArray();
        $expected = [
            'acme' => [
                'top_hits' => $expectedAgg,
            ],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }

    /**
     * Tests if adding parameters has any effect.
     */
    public function testParameters()
    {
        $topHitsAggregation = new TopHitsAggregation('test');
        $topHitsAggregation->addParameter('_source', ['include' => ['title']]);
        $expectedAgg = new \stdClass();
        $expectedAgg->sort = [];
        $expectedAgg->_source = ['include' => ['title']];
        $expected = [
            'agg_test' => [
                'top_hits' => $expectedAgg,
            ],
        ];

        $this->assertEquals($expected, $topHitsAggregation->toArray());
    }
}
