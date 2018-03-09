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

use ONGR\ElasticsearchDSL\Aggregation\Pipeline\DerivativeAggregation;

/**
 * Unit test for derivative aggregation.
 */
class DerivativeAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests toArray method.
     */
    public function testToArray()
    {
        $aggregation = new DerivativeAggregation('foo', 'foo>bar');
        $aggregation->addParameter('gap_policy', 'skip');

        $expected = [
            'derivative' => [
                'buckets_path' => 'foo>bar',
                'gap_policy' => 'skip'
            ]
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }
}
