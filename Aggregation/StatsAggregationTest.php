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

use ONGR\ElasticsearchBundle\DSL\Aggregation\StatsAggregation;

class StatsAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for stats aggregation toArray() method.
     */
    public function testToArray()
    {
        $aggregation = new StatsAggregation('test_agg');
        $aggregation->setField('test_field');

        $expectedResult = [
            'agg_test_agg' => [
                'stats' => [
                    'field' => 'test_field',
                ],
            ],
        ];

        $this->assertEquals($expectedResult, $aggregation->toArray());
    }
}
