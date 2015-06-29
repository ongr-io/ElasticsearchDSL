<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Filter;

use ONGR\ElasticsearchDSL\Filter\IndicesFilter;

class IndicesFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new IndicesFilter([], '', null);
        $this->assertEquals('indices', $filter->getType());
    }

    /**
     * Tests if Indices qty is greater than one.
     */
    public function testToArrayIfIndicesQtyIsGreaterThanOne()
    {
        $mockBuilder = $this->indicesQtyMockBuilder(['test_field' => ['test_value' => 'test']]);

        $filter = new IndicesFilter(['foo', 'bar'], $mockBuilder, null);
        $expectedResult = [
            'indices' => [0 => 'foo', 1 => 'bar'],
            'filter' => ['term' => ['test_field' => ['test_value' => 'test']]],
        ];
        $result = $filter->toArray();
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Test if Indices qty is less than one.
     */
    public function testToArrayIfIndicesQtyIsLessThanOne()
    {
        $mockBuilder = $this->indicesQtyMockBuilder(['test_field' => ['test_value' => 'test']]);
        $filter = new IndicesFilter(['foo'], $mockBuilder, null);
        $expectedResult = ['index' => 'foo', 'filter' => ['term' => ['test_field' => ['test_value' => 'test']]]];
        $result = $filter->toArray();
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Test.
     */
    public function testWhenNoMatchFilterIsNotNull()
    {
        $mockBuilder = $this->indicesQtyMockBuilder(['tag' => 'wow']);
        $noMatchFilterMockBuilder = $this->indicesQtyMockBuilder(['tag' => 'kow']);
        $filter = new IndicesFilter(['foo'], $mockBuilder, $noMatchFilterMockBuilder);
        $expectedResult = [
            'index' => 'foo',
            'filter' => ['term' => ['tag' => 'wow']],
            'no_match_filter' => ['term' => ['tag' => 'kow']],
        ];
        $result = $filter->toArray();
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Test.
     */
    public function testWhenNoMatchFilterIsEmpty()
    {
        $mockBuilder = $this->indicesQtyMockBuilder(['tag' => 'wow']);
        $filter = new IndicesFilter(['foo'], $mockBuilder, '');
        $expectedResult = [
            'index' => 'foo',
            'filter' => ['term' => ['tag' => 'wow']],
            'no_match_filter' => '',
        ];
        $result = $filter->toArray();
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Mock Builder.
     *
     * @param array $param Expected values.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function indicesQtyMockBuilder(array $param = [])
    {
        $mockBuilder = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')
            ->getMock();
        $mockBuilder->expects($this->any())
            ->method('getType')
            ->willReturn('term');
        $mockBuilder->expects($this->any())
            ->method('toArray')
            ->willReturn($param);

        return $mockBuilder;
    }
}
