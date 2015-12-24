<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Aggregation;

use ONGR\ElasticsearchDSL\Query\BoolQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Query\TermQuery;

/**
 * Unit test for Bool.
 */
class BoolQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests isRelevant method.
     */
    public function testIsRelevant()
    {
        $bool = new BoolQuery();
        $this->assertTrue($bool->isRelevant());
    }
    /**
     * Test for addToBool() without setting a correct bool operator.
     *
     * @expectedException        \UnexpectedValueException
     * @expectedExceptionMessage The bool operator acme is not supported
     */
    public function testBoolAddToBoolException()
    {
        $bool = new BoolQuery();
        $bool->add(new MatchAllQuery(), 'acme');
    }

    /**
     * Tests toArray() method.
     */
    public function testBoolToArray()
    {
        $bool = new BoolQuery();
        $bool->add(new TermQuery('key1', 'value1'), BoolQuery::SHOULD);
        $bool->add(new TermQuery('key2', 'value2'), BoolQuery::MUST);
        $bool->add(new TermQuery('key3', 'value3'), BoolQuery::MUST_NOT);
        $expected = [
            'should' => [
                [
                    'term' => [
                        'key1' => 'value1',
                    ],
                ],
            ],
            'must' => [
                [
                    'term' => [
                        'key2' => 'value2',
                    ],
                ],
            ],
            'must_not' => [
                [
                    'term' => [
                        'key3' => 'value3',
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $bool->toArray());
    }

    /**
     * Test getType method.
     */
    public function testBoolGetType()
    {
        $bool = new BoolQuery();
        $result = $bool->getType();
        $this->assertEquals('bool', $result);
    }

    /**
     * Tests bool query in filter context.
     */
    public function testBoolInFilterContext()
    {
        $bool = new BoolQuery();
        $bool->add(new TermQuery('key1', 'value1'), BoolQuery::FILTER);
        $bool->add(new TermQuery('key2', 'value2'), BoolQuery::MUST);
        $expected = [
            'filter' => [
                [
                    'term' => [
                        'key1' => 'value1',
                    ],
                ],
            ],
            'must' => [
                [
                    'term' => [
                        'key2' => 'value2',
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $bool->toArray());
    }
}
