<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Query;

use ONGR\ElasticsearchDSL\Query\NestedQuery;

class NestedQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests toArray method.
     */
    public function testToArray()
    {
        $missingFilterMock = $this->getMockBuilder('ONGR\ElasticsearchDSL\Filter\MissingFilter')
            ->setConstructorArgs(['test_field'])
            ->getMock();
        $missingFilterMock->expects($this->any())
            ->method('getType')
            ->willReturn('test_type');
        $missingFilterMock->expects($this->any())
            ->method('toArray')
            ->willReturn(['testKey' => 'testValue']);

        $result = [
            'path' => 'test_path',
            'query' => [
                'test_type' => ['testKey' => 'testValue'],
            ],
        ];

        $query = new NestedQuery('test_path', $missingFilterMock);
        $this->assertEquals($result, $query->toArray());
    }

    /**
     * Tests if Nested Query has parameters.
     */
    public function testParameters()
    {
        $nestedQuery = $this->getMockBuilder('ONGR\ElasticsearchDSL\Query\NestedQuery')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->assertTrue(method_exists($nestedQuery, 'addParameter'), 'Nested query must have addParameter method');
        $this->assertTrue(method_exists($nestedQuery, 'setParameters'), 'Nested query must have setParameters method');
        $this->assertTrue(method_exists($nestedQuery, 'getParameters'), 'Nested query must have getParameters method');
        $this->assertTrue(method_exists($nestedQuery, 'hasParameter'), 'Nested query must have hasParameter method');
        $this->assertTrue(method_exists($nestedQuery, 'getParameter'), 'Nested query must have getParameter method');
    }
}
