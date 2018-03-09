<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use ONGR\ElasticsearchDSL\Aggregation\Pipeline\ExtendedStatsBucketAggregation;

/**
 * Unit test for stats bucket aggregation.
 */
class ExtendedStatsBucketAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests toArray method.
     */
    public function testToArray()
    {
        $aggregation = new ExtendedStatsBucketAggregation('acme', 'test');

        $expected = [
            'extended_stats_bucket' => [
                'buckets_path' => 'test',
            ],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }
}
