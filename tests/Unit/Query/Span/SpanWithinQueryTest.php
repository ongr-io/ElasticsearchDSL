<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Span;

use ONGR\ElasticsearchDSL\Query\Span\SpanWithinQuery;

/**
 * Unit test for SpanWithinQuery.
 */
class SpanWithinQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests for toArray().
     */
    public function testToArray()
    {
        $query = new SpanWithinQuery(
            $this->getSpanQueryMock('foo'),
            $this->getSpanQueryMock('bar')
        );
        $result = [
            'span_within' => [
                'little' => [
                    'span_term' => ['user' => 'foo'],
                ],
                'big' => [
                    'span_term' => ['user' => 'bar'],
                ],
            ],
        ];
        $this->assertEquals($result, $query->toArray());
    }

    /**
     * @param string $value
     *
     * @returns \PHPUnit_Framework_MockObject_MockObject
     */
    private function getSpanQueryMock($value)
    {
        $mock = $this->getMock('ONGR\ElasticsearchDSL\Query\Span\SpanQueryInterface');
        $mock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn(['span_term' => ['user' => $value]]);
        return $mock;
    }
}
