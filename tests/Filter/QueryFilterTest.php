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

use ONGR\ElasticsearchDSL\Filter\QueryFilter;

class QueryFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test query with '_cache' parameter.
     */
    public function testToArrayWithGetTypeFqueryWithCache()
    {
        $mockBuilder = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')
            ->getMock();
        $mockBuilder->expects($this->any())
            ->method('getType')
            ->willReturn('fquery');
        $filter = new QueryFilter($mockBuilder, ['_cache' => true]);
        $result = $filter->toArray();
        $expectedResult = ['query' => ['fquery' => null], '_cache' => true];
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Test query without '_cache' parameter.
     */
    public function testToArrayWithGetTypeQueryWithoutCache()
    {
        $mockBuilder = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')
            ->getMock();
        $mockBuilder->expects($this->any())
            ->method('getType')
            ->willReturn('query');
        $filter = new QueryFilter($mockBuilder, []);
        $result = $filter->toArray();
        $expectedResult = ['query' => null];
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * Test GetType function, returns 'fquery'.
     */
    public function testGetTypeWhenReturnsStringFquery()
    {
        $filter = new QueryFilter('', ['_cache' => true]);
        $this->assertEquals('fquery', $filter->getType());
    }

    /**
     * Test GetType function, returns 'query'.
     */
    public function testgetTypeWhenReturnsStringQuery()
    {
        $filter = new QueryFilter('', []);
        $this->assertEquals('query', $filter->getType());
    }
}
