<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Query;

use ONGR\ElasticsearchDSL\Query\AndQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Query\TermQuery;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;

/**
 * Unit test for And.
 */
class AndQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Queries given to `AND` query must be instances of BuilderInterface
     */
    public function testToArrayException()
    {
        $and = new AndQuery([1, 2, 3]);
        $and->toArray();
    }

    /**
     * Tests toArray() method.
     */
    public function testAndToArray()
    {
        $and = new AndQuery();
        $and->addQuery(new TermQuery('foo', 'bar'));
        $and->addQuery(new MatchAllQuery());
        $expected = [
            'and' => [
                [
                    'term' => [
                        'foo' => 'bar'
                    ]
                ],
                [
                    'match_all' => []
                ]
            ],
        ];
        $this->assertEquals($expected, $and->toArray());
    }

    /**
     * Tests bool query in filter context.
     */
    public function testGetType()
    {
        $and = new AndQuery();
        $this->assertEquals('and', $and->getType());
    }
}
