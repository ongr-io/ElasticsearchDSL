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

use ONGR\ElasticsearchBundle\DSL\Aggregation\RangeAggregation;

class RangeAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for testToArray().
     *
     * @return array
     */
    public function getToArrayData()
    {
        $out = [];

        // Case #0 single range.
        $aggregation = new RangeAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->addRange('10', 20);

        $result = [
            'agg_test_agg' => [
                'range' => [
                    'field' => 'test_field',
                    'ranges' => [
                        ['from' => '10', 'to' => 20],
                    ],
                    'keyed' => false,
                ],
            ],
        ];

        $out[] = [$aggregation, $result];

        // Case #1 multiple keyed ranges.
        $aggregation = new RangeAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->setKeyed(true);
        $aggregation->addRange('10', null, 'range_1');
        $aggregation->addRange(null, '20', 'range_2');

        $result = [
            'agg_test_agg' => [
                'range' => [
                    'field' => 'test_field',
                    'ranges' => [
                        ['from' => '10', 'key' => 'range_1'],
                        ['to' => '20', 'key' => 'range_2'],
                    ],
                    'keyed' => true,
                ],
            ],
        ];

        $out[] = [$aggregation, $result];

        // Case #2 nested aggregation.
        $aggregation = new RangeAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->addRange('10', '10');

        $aggregation2 = new RangeAggregation('test_agg_2');
        $aggregation2->addRange('20', '20');

        $aggregation->aggregations->addAggregation($aggregation2);

        $result = [
            'agg_test_agg' => [
                'range' => [
                    'field' => 'test_field',
                    'ranges' => [
                        ['from' => '10', 'to' => '10'],
                    ],
                    'keyed' => false,
                ],
                'aggregations' => [
                    'agg_test_agg_2' => [
                        'range' => [
                            'ranges' => [
                                ['from' => '20', 'to' => '20'],
                            ],
                            'keyed' => false,
                        ],
                    ],
                ],
            ],
        ];

        $out[] = [$aggregation, $result];

        return $out;
    }

    /**
     * Test for range aggregation toArray() method.
     *
     * @param RangeAggregation $aggregation
     * @param array            $expectedResult
     *
     * @dataProvider           getToArrayData
     */
    public function testToArray($aggregation, $expectedResult)
    {
        $this->assertEquals($expectedResult, $aggregation->toArray());
    }
}
