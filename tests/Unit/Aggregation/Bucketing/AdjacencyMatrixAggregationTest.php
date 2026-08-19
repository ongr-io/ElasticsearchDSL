<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Tests\Unit\Bucketing\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\AdjacencyMatrixAggregation;
use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Unit test for adjacency matrix aggregation.
 */
class AdjacencyMatrixAggregationTest extends \PHPUnit\Framework\TestCase
{
    public function testFiltersAggregationGetArray(): void
    {
        $mock = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')->getMock();
        $aggregation = new AdjacencyMatrixAggregation('test_agg');
        $aggregation->addFilter('name', $mock);
        $result = $aggregation->getArray();
        $this->assertArrayHasKey('filters', $result);
    }

    public function testFiltersAggregationGetType(): void
    {
        $aggregation = new AdjacencyMatrixAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('adjacency_matrix', $result);
    }

    public function testToArray(): void
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

    public function testFilterConstructor(): void
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
