<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Aggregation;

use ONGR\ElasticsearchBundle\DSL\Aggregation\NestedAggregation;

class NestedAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for nested aggregation toArray() method.
     */
    public function testToArray()
    {
        $aggregation = new NestedAggregation('test_agg');
        $aggregation->setPath('test_path');

        $expectedResult = [
            'agg_test_agg' => [
                'nested' => ['path' => 'test_path'],
            ],
        ];

        $this->assertEquals($expectedResult, $aggregation->toArray());
    }
}
