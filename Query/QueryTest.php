<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Query;

use ONGR\ElasticsearchBundle\DSL\Query\Query;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests setBoolParameters method.
     */
    public function testSetBoolParameters()
    {
        $missingFilterMock = $this->getMockBuilder('ONGR\ElasticsearchBundle\DSL\Filter\MissingFilter')
            ->setConstructorArgs(['test_field'])
            ->getMock();
        $missingFilterMock->expects($this->once())
            ->method('setParameters');

        $query = new Query();
        $query->setQuery($missingFilterMock);
        $query->setBoolParameters([false]);
    }

    /**
     * Tests addQuery method.
     */
    public function testAddQuery()
    {
        $missingFilterMock = $this
            ->getMockBuilder('ONGR\ElasticsearchBundle\DSL\Filter\MissingFilter')
            ->disableOriginalConstructor()
            ->setMethods(['add'])
            ->getMock();
        $missingFilterMock
            ->expects($this->once())
            ->method('add')
            ->withAnyParameters();
        $postFilterMock = $this
            ->getMockBuilder('ONGR\ElasticsearchBundle\DSL\Filter\PostFilter')
            ->disableOriginalConstructor()
            ->getMock();

        $query = new Query();
        $query->setQuery($missingFilterMock);
        $query->addQuery($postFilterMock);
    }

    /**
     * Tests getType method.
     */
    public function testGetType()
    {
        $query = new Query();
        $this->assertEquals('query', $query->getType());
    }

    /**
     * Tests toArray method.
     */
    public function testToArray()
    {
        $missingFilterMock = $this->getMockBuilder('ONGR\ElasticsearchBundle\DSL\Filter\MissingFilter')
            ->disableOriginalConstructor()
            ->getMock();
        $missingFilterMock->expects($this->once())
            ->method('getType')
            ->willReturn('test_type');
        $missingFilterMock->expects($this->once())
            ->method('toArray')
            ->willReturn('test_array');

        $query = new Query();
        $query->setQuery($missingFilterMock);
        $this->assertEquals(['test_type' => 'test_array'], $query->toArray());
    }
}
