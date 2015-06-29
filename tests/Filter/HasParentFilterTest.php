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

use ONGR\ElasticsearchDSL\Filter\HasParentFilter;

class HasParentFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $mock = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')->getMock();
        $filter = new HasParentFilter('test_field', $mock);
        $result = $filter->getType();
        $this->assertEquals('has_parent', $result);
    }

    /**
     * Data provider to testToArray.
     *
     * @return array
     */
    public function getArrayDataProvider()
    {
        return [
            // Case #1.
            [
                'content',
                'term',
                ['title' => 'nested'],
                [],
                'filter',
                ['parent_type' => 'content', 'filter' => ['term' => ['title' => 'nested']]],
            ],
            // Case #2.
            [
                'content',
                'term',
                ['title' => 'nested'],
                ['parameter' => 'value'],
                'query',
                ['parent_type' => 'content', 'query' => ['term' => ['title' => 'nested']], 'parameter' => 'value'],
            ],
        ];
    }

    /**
     * Tests toArray method.
     *
     * @param string $parentType   Parent type.
     * @param string $queryType    Type of query for mock query class.
     * @param array  $queryToArray Return value for mock query class toArray method.
     * @param array  $parameters   Optional parameters.
     * @param string $dslType      Filter or query.
     * @param array  $expected     Expected result.
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray($parentType, $queryType, $queryToArray, $parameters, $dslType, $expected)
    {
        $mockQuery = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')->getMock();
        $mockQuery->expects($this->once())
            ->method('getType')
            ->will($this->returnValue($queryType));
        $mockQuery->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue($queryToArray));

        $filter = new HasParentFilter($parentType, $mockQuery, $parameters);
        $filter->setDslType($dslType);
        $result = $filter->toArray();
        $this->assertEquals($expected, $result);
    }
}
