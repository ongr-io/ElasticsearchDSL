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

use ONGR\ElasticsearchDSL\Aggregation\FilterAggregation;
use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Filter\MissingFilter;

class FilterAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for testToArray.
     *
     * @return array
     */
    public function getToArrayData()
    {
        $out = [];

        // Case #0 filter aggregation.
        $aggregation = new FilterAggregation('test_agg');

        $filter = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')
            ->setMethods(['toArray', 'getType'])
            ->getMockForAbstractClass();
        $filter->expects($this->any())
            ->method('getType')
            ->willReturn('test_filter');
        $filter->expects($this->any())
            ->method('toArray')
            ->willReturn(['test_field' => ['test_value' => 'test']]);

        $aggregation->setFilter($filter);

        $result = [
            'test_agg' => [
                'filter' => [
                    'test_filter' => [
                        'test_field' => ['test_value' => 'test'],
                    ],
                ],
            ],
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        // Case #1 nested filter aggregation.
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->setFilter($filter);

        $aggregation2 = $this->getMockBuilder('ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation')
            ->disableOriginalConstructor()
            ->setMethods(['toArray', 'getName'])
            ->getMockForAbstractClass();
        $aggregation2->expects($this->any())
            ->method('toArray')
            ->willReturn(['test_agg2' => ['avg' => []]]);
        $aggregation2->expects($this->any())
            ->method('getName')
            ->willReturn('test_agg2');

        $aggregation->addAggregation($aggregation2);

        $result = [
            'test_agg' => [
                'filter' => [
                    'test_filter' => [
                        'test_field' => ['test_value' => 'test'],
                    ],
                ],
                'aggregations' => [
                    'test_agg2' => [
                        'avg' => [],
                    ],
                ],
            ],
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        return $out;
    }

    /**
     * Test for filter aggregation toArray() method.
     *
     * @param FilterAggregation $aggregation
     * @param array             $expectedResult
     *
     * @dataProvider getToArrayData
     */
    public function testToArray($aggregation, $expectedResult)
    {
        $this->assertEquals($expectedResult, $aggregation->toArray());
    }

    /**
     * Test for setField().
     *
     * @expectedException        \LogicException
     * @expectedExceptionMessage doesn't support `field` parameter
     */
    public function testSetField()
    {
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->setField('test_field');
    }

    /**
     * Test for toArray() without setting a filter.
     *
     * @expectedException        \LogicException
     * @expectedExceptionMessage has no filter added
     */
    public function testToArrayNoFilter()
    {
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->toArray();
    }

    /**
     * Test for toArray() with setting a filter.
     */
    public function testToArrayWithFilter()
    {
        $aggregation = new FilterAggregation('test_agg');

        $aggregation->setFilter(new MissingFilter('test'));
        $aggregation->toArray();
    }

    /**
     * Tests if filter can be passed to constructor.
     */
    public function testConstructorFilter()
    {
        /** @var BuilderInterface|\PHPUnit_Framework_MockObject_MockObject $builderInterface */
        $builderInterface = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        $aggregation = new FilterAggregation('test', $builderInterface);
        $this->assertSame(
            [
                'test' => [
                    'filter' => [null => null],
                ],
            ],
            $aggregation->toArray()
        );
    }
}
