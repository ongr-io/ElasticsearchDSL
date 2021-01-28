<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Compound;

use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use UnexpectedValueException;

/**
 * Unit test for Bool.
 */
class BoolQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testBoolAddToBoolException(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The bool operator acme is not supported');

        $bool = new BoolQuery();
        $bool->add(new MatchAllQuery(), 'acme');
    }

    public function testBoolConstructor(): void
    {
        $bool = new BoolQuery([
            BoolQuery::SHOULD => [new TermQuery('key1', 'value1')],
            BoolQuery::MUST => [
                new TermQuery('key2', 'value2'),
                new TermQuery('key3', 'value3'),
            ],
            BoolQuery::MUST_NOT => [new TermQuery('key4', 'value4')]
        ]);

        $expected = [
            'bool' => [
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
                    [
                        'term' => [
                            'key3' => 'value3',
                        ],
                    ],
                ],
                'must_not' => [
                    [
                        'term' => [
                            'key4' => 'value4',
                        ],
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $bool->toArray());
    }

    public function testBoolConstructorException(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The bool operator acme is not supported');

        new BoolQuery([
            'acme' => [new TermQuery('key1', 'value1')],
        ]);
    }

    public function testBoolToArray(): void
    {
        $bool = new BoolQuery();
        $bool->add(new TermQuery('key1', 'value1'), BoolQuery::SHOULD);
        $bool->add(new TermQuery('key2', 'value2'), BoolQuery::MUST);
        $bool->add(new TermQuery('key3', 'value3'), BoolQuery::MUST_NOT);
        $expected = [
            'bool' => [
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
            ],
        ];
        $this->assertEquals($expected, $bool->toArray());
    }

    public function testEmptyBoolQuery():void
    {
        $bool = new BoolQuery();

        $this->assertEquals(['bool' => new \stdClass()], $bool->toArray());
    }

    public function testBoolInFilterContext(): void
    {
        $bool = new BoolQuery();
        $bool->add(new TermQuery('key1', 'value1'), BoolQuery::FILTER);
        $bool->add(new TermQuery('key2', 'value2'), BoolQuery::MUST);
        $expected = [
            'bool' => [
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
            ],
        ];
        $this->assertEquals($expected, $bool->toArray());
    }

    public function testSingleMust(): void
    {
        $bool = new BoolQuery();
        $bool->add(new TermQuery('key2', 'value2'), BoolQuery::MUST);
        $expected = [
            'term' => [
                'key2' => 'value2',
            ],
        ];
        $this->assertEquals($expected, $bool->toArray());
    }

    public function testGetQueriesEmpty(): void
    {
        $bool = new BoolQuery();

        $this->assertIsArray($bool->getQueries());
    }

    public function testGetQueries(): void
    {
        $query = new TermQuery('key1', 'value1');
        $query2 = new TermQuery('key2', 'value2');

        $bool = new BoolQuery();
        $bool->add($query, BoolQuery::MUST, 'query');
        $bool->add($query2, BoolQuery::SHOULD, 'query2');

        $this->assertSame(array('query' => $query, 'query2' => $query2), $bool->getQueries());
    }

    public function testGetQueriesByBoolTypeEmpty(): void
    {
        $bool = new BoolQuery();

        $this->assertIsArray($bool->getQueries(BoolQuery::MUST));
    }

    public function testGetQueriesByBoolTypeWithQueryAddedToBoolType(): void
    {
        $query = new TermQuery('key1', 'value1');
        $query2 = new TermQuery('key2', 'value2');

        $bool = new BoolQuery();
        $bool->add($query, BoolQuery::MUST, 'query');
        $bool->add($query2, BoolQuery::SHOULD, 'query2');

        $this->assertSame(array('query' => $query), $bool->getQueries(BoolQuery::MUST));
    }
}
