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

use ONGR\ElasticsearchDSL\Query\Span\SpanOrQuery;
use ONGR\ElasticsearchDSL\Query\Span\SpanQueryInterface;

/**
 * Unit test for SpanOrQuery.
 */
class SpanOrQueryTest extends \PHPUnit_Framework_TestCase
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
        $this->mock->expects($this->atMost(1))
            ->method('getType')
            ->will($this->returnValue('span_or'));
        $this->mock->expects($this->atMost(1))
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
    public function testSpanOrQueryGetType()
    {
        $query = new SpanOrQuery();
        $result = $query->getType();
        $this->assertEquals('span_or', $result);
    }

    /**
     * Tests toArray method.
     */
    public function testSpanOrQueryToArray()
    {
        /** @var SpanQueryInterface $mock */
        $mock = $this->mock;
        $query = new SpanOrQuery();
        $query->addQuery($mock);
        $result = [
            'clauses' => [
                0 => [
                    'span_or' => ['key' => 'value'],
                ],
            ],
        ];
        $this->assertEquals($result, $query->toArray());

        $result = $query->getQueries();
        $this->assertInternalType('array', $result);
        $this->assertEquals(1, count($result));
    }
}
