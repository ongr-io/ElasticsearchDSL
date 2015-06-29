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

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Query\Span\SpanMultiTermQuery;

/**
 * Unit test for SpanMultiTermQuery.
 */
class SpanMultiTermQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array.
     */
    protected $mock;

    /**
     * Create mock object.
     */
    protected function setUp()
    {
        $allowedQueries = ['\FuzzyQuery', '\PrefixQuery', '\TermQuery', '\WildcardQuery', '\RegexpQuery'];
        // Same constructors for all of these queries.
        foreach ($allowedQueries as $query) {
            $this->mock[$query] = $this->getMockBuilder('ONGR\ElasticsearchDSL\Query' . "{$query}")
                ->setConstructorArgs(['field', 'value'])
                ->getMock();
            $this->mock[$query]->expects($this->atMost(1))
                ->method('getType')
                ->will($this->returnValue('span'));
            $this->mock[$query]->expects($this->atMost(1))
                ->method('toArray')
                ->will($this->returnValue(['field' => 'value']));
        }
    }

    /**
     * Reset mock object.
     */
    public function tearDown()
    {
        unset($this->mock);
    }

    /**
     * Tests toArray method using these queries: Fuzzy, Prefix, Term, Wildcard, Regexp.
     */
    public function testSpanMultiTermQueryToArray()
    {
        /** @var BuilderInterface $mock */
        $mock = $this->mock;

        foreach ($mock as $mocked) {
            $query = new SpanMultiTermQuery($mocked);
            $result = [
                'match' => [
                    'span' => [
                        'field' => 'value',
                    ],
                ],
            ];
            $this->assertEquals($result, $query->toArray());
        }
    }

    /**
     * Tests toArray method using this query: Range.
     */
    public function testSpanMultiTermQueryToArrayNext()
    {
        /** @var BuilderInterface $mock */
        $mock = $this->getMockBuilder('ONGR\ElasticsearchDSL\Query\RangeQuery')
            ->setConstructorArgs(['field', ['gte']])
            ->getMock();
        $mock->expects($this->once())
            ->method('getType')
            ->will($this->returnValue('range'));
        $mock->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue(['field' => ['gte']]));

        $query = new SpanMultiTermQuery($mock);
        $result = [
            'match' => [
                'range' => [
                    'field' => ['gte'],
                ],
            ],
        ];
        $this->assertEquals($result, $query->toArray());
    }

    /**
     * Tests get Type method.
     */
    public function testSpanMultiTermQueryGetType()
    {
        /** @var BuilderInterface $mock */
        $mock = $this->mock['\FuzzyQuery'];
        $query = new SpanMultiTermQuery($mock);
        $result = $query->getType();
        $this->assertEquals('span_multi', $result);
    }
}
