<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Bucketing\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\AdjacencyMatrixAggregation;
use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Unit test for adjacency matrix aggregation.
 */
class AdjacencyMatrixAggregationTest extends \PHPUnit\Framework\TestCase
{
//    /**
//     * Test if exception is thrown when not anonymous filter is without name.
//     *
//     * @expectedException \LogicException
//     * @expectedExceptionMessage In not anonymous filters filter name must be set.
//     */
//    public function testIfExceptionIsThrown()
//    {
//        $mock = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')->getMock();
//        $aggregation = new FiltersAggregation('test_agg');
//        $aggregation->addFilter($mock);
//    }

    /**
     * Test GetArray method.
     */
    public function testFiltersAggregationGetArray()
    {
        $mock = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')->getMock();
        $aggregation = new AdjacencyMatrixAggregation('test_agg');
        $aggregation->addFilter('name', $mock);
        $result = $aggregation->getArray();
        $this->assertArrayHasKey('filters', $result);
    }

    /**
     * Tests getType method.
     */
    public function testFiltersAggregationGetType()
    {
        $aggregation = new AdjacencyMatrixAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('adjacency_matrix', $result);
    }

    /**
     * Test for filter aggregation toArray() method.
     */
    public function testToArray()
    {
        $aggregation = new AdjacencyMatrixAggregation('test_agg');
        $filter = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')
            ->setMethods(['toArray', 'getType'])
            ->getMockForAbstractClass();
        $filter->expects($this->any())
            ->method('toArray')
            ->willReturn(['test_field' => ['test_value' => 'test']]);

        $aggregation->addFilter('first', $filter);
        $aggregation->addFilter('second', $filter);

        $results = $aggregation->toArray();
        $expected = [
            'adjacency_matrix' => [
                'filters' => [
                    'first' => [
                        'test_field' => [
                            'test_value' => 'test',
                        ],
                    ],
                    'second' => [
                        'test_field' => [
                            'test_value' => 'test',
                        ],
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $results);
    }

    /**
     * Tests if filters can be passed to the constructor.
     */
    public function testFilterConstructor()
    {
        /** @var BuilderInterface|\PHPUnit_Framework_MockObject_MockObject $builderInterface1 */
        $builderInterface1 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        /** @var BuilderInterface|\PHPUnit_Framework_MockObject_MockObject $builderInterface2 */
        $builderInterface2 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');

        $aggregation = new AdjacencyMatrixAggregation(
            'test',
            [
                'filter1' => $builderInterface1,
                'filter2' => $builderInterface2,
            ]
        );

        $this->assertSame(
            [
                'adjacency_matrix' => [
                    'filters' => [
                        'filter1' => null,
                        'filter2' => null,
                    ],
                ],
            ],
            $aggregation->toArray()
        );

        $aggregation = new AdjacencyMatrixAggregation('test');

        $this->assertSame(
            [
                'adjacency_matrix' => [
                    'filters' => [],
                ],
            ],
            $aggregation->toArray()
        );
    }
}
