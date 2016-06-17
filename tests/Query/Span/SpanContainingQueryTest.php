<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Query\Span;

use ONGR\ElasticsearchDSL\Query\Span\SpanContainingQuery;

/**
 * Unit test for SpanContainingQuery.
 */
class SpanContainingQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests for toArray().
     */
    public function testToArray()
    {
        $query = new SpanContainingQuery(
            $this->getSpanQueryMack('foo'),
            $this->getSpanQueryMack('bar')
        );
        $result = [
            'span_containing' => [
                'little' => [
                    'span_term' => ['user' => 'bar'],
                ],
                'big' => [
                    'span_term' => ['user' => 'foo'],
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
    private function getSpanQueryMack($value)
    {
        $mock = $this->getMock('ONGR\ElasticsearchDSL\Query\Span\SpanQueryInterface');
        $mock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn(['span_term' => ['user' => $value]]);
        return $mock;
    }
}
