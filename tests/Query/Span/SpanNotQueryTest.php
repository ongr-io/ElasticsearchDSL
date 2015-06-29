<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Query\Span;

use ONGR\ElasticsearchDSL\Query\Span\SpanNotQuery;
use ONGR\ElasticsearchDSL\Query\Span\SpanQueryInterface;

/**
 * Unit test for SpanNotQuery.
 */
class SpanNotQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Object.
     */
    protected $mock;

    /**
     * Create mock object.
     */
    protected function setUp()
    {
        $this->mock = $this->getMockBuilder('ONGR\ElasticsearchDSL\Query\Span\SpanQueryInterface')->getMock();
        $this->mock->expects($this->atMost(2))
            ->method('getType')
            ->will($this->returnValue('span_or'));
        $this->mock->expects($this->atMost(2))
            ->method('toArray')
            ->will($this->returnValue(['key' => 'value']));
    }

    /**
     * Reset mock object.
     */
    public function tearDown()
    {
        unset($this->mock);
    }

    /**
     * Tests get Type method.
     */
    public function testSpanNotQueryGetType()
    {
        /** @var SpanQueryInterface $mock */
        $mock = $this->mock;
        $query = new SpanNotQuery($mock, $mock);
        $result = $query->getType();
        $this->assertEquals('span_not', $result);
    }

    /**
     * Tests toArray method.
     */
    public function testSpanNotQueryToArray()
    {
        /** @var SpanQueryInterface $mock */
        $mock = $this->mock;
        $query = new SpanNotQuery($mock, $mock);
        $result = [
            'include' => [
                'span_or' => ['key' => 'value'],
            ],
            'exclude' => [
                'span_or' => ['key' => 'value'],
            ],
        ];
        $this->assertEquals($result, $query->toArray());
    }
}
