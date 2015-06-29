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

use ONGR\ElasticsearchDSL\Query\Span\SpanFirstQuery;
use ONGR\ElasticsearchDSL\Query\Span\SpanQueryInterface;

/**
 * Unit test for SpanFirstQuery.
 */
class SpanFirstQueryTest extends \PHPUnit_Framework_TestCase
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
     * Tests toArray method.
     */
    public function testSpanFirstQueryToArray()
    {
        /** @var SpanQueryInterface $mock */
        $mock = $this->mock;
        $query = new SpanFirstQuery($mock, 5);
        $result = [
            'match' => [
                'span_or' => [ 'key' => 'value'],
            ],
            'end' => 5,
        ];
        $this->assertEquals($result, $query->toArray());
    }

    /**
     * Tests get Type method.
     */
    public function testSpanFirstQueryGetType()
    {
        /** @var SpanQueryInterface $mock */
        $mock = $this->mock;
        $query = new SpanFirstQuery($mock, 5);
        $result = $query->getType();
        $this->assertEquals('span_first', $result);
    }
}
