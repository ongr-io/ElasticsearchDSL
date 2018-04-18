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

use ONGR\ElasticsearchDSL\Query\Span\SpanMultiTermQuery;

/**
 * Unit test for SpanMultiTermQuery.
 */
class SpanMultiTermQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test for toArray().
     */
    public function testToArray()
    {
        $mock = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')->getMock();
        $mock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn(['prefix' => ['user' => ['value' => 'ki']]]);

        $query = new SpanMultiTermQuery($mock);
        $expected = [
            'span_multi' => [
                'match' => [
                    'prefix' => ['user' => ['value' => 'ki']],
                ],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
