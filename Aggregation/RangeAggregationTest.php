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
     * Test addRange method.
     */
    public function testRangeAggregationAddRange()
    {
        // Case #0 single range.
        $aggregation = new RangeAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->addRange('10', 20);

        $result = [
            'agg_test_agg' => [
                'range' => [
                    'field' => 'test_field',
                    'ranges' => [
                        [
                            'from' => '10',
                            'to' => 20,
                        ],
                    ],
                    'keyed' => false,
                ],
            ],
        ];

        $this->assertEquals($result, $aggregation->toArray());
    }

    /**
     * Test addRange method with multiple values.
     */
    public function testRangeAggregationAddRangeMultiple()
    {
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
                        [
                            'from' => '10',
                            'key' => 'range_1',
                        ],
                        [
                            'to' => '20',
                            'key' => 'range_2',
                        ],
                    ],
                    'keyed' => true,
                ],
            ],
        ];

        $this->assertEquals($result, $aggregation->toArray());
    }

    /**
     * Test addRange method with nested values.
     */
    public function testRangeAggregationAddRangeNested()
    {
        // Case #2 nested aggregation.
        $aggregation = new RangeAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->addRange('10', '10');

        $aggregation2 = new RangeAggregation('test_agg_2');
        $aggregation2->addRange('20', '20');

        $aggregation->addAggregation($aggregation2);

        $result = [
            'agg_test_agg' => [
                'range' => [
                    'field' => 'test_field',
                    'ranges' => [
                        [
                            'from' => '10',
                            'to' => '10',
                        ],
                    ],
                    'keyed' => false,
                ],
                'aggregations' => [
                    'agg_test_agg_2' => [
                        'range' => [
                            'ranges' => [
                                [
                                    'from' => '20',
                                    'to' => '20',
                                ],
                            ],
                            'keyed' => false,
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($result, $aggregation->toArray());
    }

    /**
     * Tests getType method.
     */
    public function testRangeAggregationGetType()
    {
        $agg = new RangeAggregation('foo');
        $result = $agg->getType();
        $this->assertEquals('range', $result);
    }

    /**
     * Data provider for testRangeAggregationRemoveRangeByKey(), testRangeAggregationRemoveRange().
     *
     * @return array
     */
    public function testRangeAggregationDataProvider()
    {
        $expectedResults = [
            'field' => 'price',
            'keyed' => true,
            'ranges' => [
                [
                    'from' => 100,
                    'to' => 300,
                    'key' => 'key',
                ],
            ],
        ];

        return [[$expectedResults]];
    }

    /**
     * Tests removeRangeByKey method.
     *
     * @param array $expected
     *
     * @dataProvider testRangeAggregationDataProvider
     */
    public function testRangeAggregationRemoveRangeByKey($expected)
    {
        $aggregation = new RangeAggregation('foo');
        $aggregation->setField('price');
        $aggregation->setKeyed(true);
        $aggregation->addRange(100, 300, 'key');

        $result = $aggregation->getArray();
        $this->assertEquals($result, $expected);

        $result = $aggregation->removeRangeByKey('key');
        $this->assertTrue($result);

        $result = $aggregation->removeRangeByKey('not_existing_key');
        $this->assertFalse($result);
        // Test with keyed=false.
        $aggregation->setKeyed(false);
        $result = $aggregation->removeRangeByKey('not_existing_key');
        $this->assertFalse($result);

        $aggregation->addRange(100, 300, 'key');
        $result = $aggregation->removeRangeByKey('key');
        $this->assertFalse($result);
    }

    /**
     * Tests removeRange method.
     *
     * @param array $expected
     *
     * @dataProvider testRangeAggregationDataProvider
     */
    public function testRangeAggregationRemoveRange($expected)
    {
        $aggregation = new RangeAggregation('foo');
        $aggregation->setField('price');
        $aggregation->setKeyed(true);
        $aggregation->addRange(100, 300, 'key');
        $aggregation->addRange(500, 700, 'range_2');

        $aggregation->removeRange(500, 700);
        $result = $aggregation->getArray();
        $this->assertEquals($result, $expected);
        // Test fake ranges.
        $result = $aggregation->removeRange(500, 700);
        $this->assertFalse($result);
    }
}
