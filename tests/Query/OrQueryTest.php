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

use ONGR\ElasticsearchDSL\Query\OrQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Query\TermQuery;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;

/**
 * Unit test for Or.
 */
class OrQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for addToBool() without setting a correct bool operator.
     *
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Queries given to `OR` query must be instances of BuilderInterface
     */
    public function testToArrayException()
    {
        $or = new OrQuery([1, 2, 3]);
        $or->toArray();
    }

    /**
     * Tests toArray() method.
     */
    public function testOrToArray()
    {
        $or = new OrQuery();
        $or->addQuery(new TermQuery('foo', 'bar'));
        $or->addQuery(new MatchAllQuery());
        $expected = [
            'or' => [
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
        $this->assertEquals($expected, $or->toArray());
    }

    /**
     * Tests getType method
     */
    public function testGetType()
    {
        $or = new OrQuery();
        $this->assertEquals('or', $or->getType());
    }
}
