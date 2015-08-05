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

use ONGR\ElasticsearchDSL\Aggregation\ReverseNestedAggregation;

class ReverseNestedAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for reverse_nested aggregation toArray() method exception.
     *
     * @expectedException \LogicException
     */
    public function testToArrayException()
    {
        $aggregation = new ReverseNestedAggregation('test_agg');
        $aggregation->setPath('test_path');

        $expectedResult = [
            'test_agg' => [
                'reverse_nested' => ['path' => 'test_path'],
            ],
        ];

        $this->assertEquals($expectedResult, $aggregation->toArray());
    }

    /**
     * Test for reverse_nested aggregation toArray() method exception.
     */
    public function testToArray()
    {
        $termMock = $this
            ->getMockBuilder('ONGR\ElasticsearchDSL\Aggregation\TermsAggregation')
            ->disableOriginalConstructor()
            ->getMock();

        $termMock
            ->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue(['terms' => []]));

        $aggregation = new ReverseNestedAggregation('test_nested_agg');
        $aggregation->setPath('test_path');
        $aggregation->addAggregation($termMock);

        $expectedResult = [
            'test_nested_agg' => [
                'reverse_nested' => ['path' => 'test_path'],
                'aggregations' => [
                    'terms' => [],
                ],
            ],
        ];

        $this->assertEquals($expectedResult, $aggregation->toArray());
    }

    /**
     * Test for reverse_nested aggregation toArray() without path.
     */
    public function testToArrayNoPath()
    {
        $termMock = $this
            ->getMockBuilder('ONGR\ElasticsearchDSL\Aggregation\TermsAggregation')
            ->disableOriginalConstructor()
            ->getMock();

        $termMock
            ->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue(['terms' => []]));

        $aggregation = new ReverseNestedAggregation('test_nested_agg');
        $aggregation->addAggregation($termMock);

        $expectedResult = [
            'test_nested_agg' => [
                'reverse_nested' => new \stdClass(),
                'aggregations' => [
                    'terms' => [],
                ],
            ],
        ];

        $this->assertEquals($expectedResult, $aggregation->toArray());
    }
}
