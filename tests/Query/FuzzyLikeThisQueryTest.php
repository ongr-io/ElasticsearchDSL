<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Query;

use ONGR\ElasticsearchDSL\Query\FuzzyLikeThisQuery;

/**
 * Class FuzzyLikeThisQueryTest.
 */
class FuzzyLikeThisQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests if toArray returns data in correct format with right data from constructor.
     */
    public function testQuery()
    {
        $fuzzyLikeThisQuery = new FuzzyLikeThisQuery(
            ['name.first', 'name.last'],
            'text like this one',
            [ 'max_query_terms' => 12 ]
        );

        $this->assertSame(
            [
                'fields' => ['name.first', 'name.last'],
                'like_text' => 'text like this one',
                'max_query_terms' => 12,
            ],
            $fuzzyLikeThisQuery->toArray()
        );
    }

    /**
     * Tests if correct type is returned.
     */
    public function testGetType()
    {
        /** @var FuzzyLikeThisQuery $fuzzyLikeThisQuery */
        $fuzzyLikeThisQuery = $this->getMockBuilder('ONGR\ElasticsearchDSL\Query\FuzzyLikeThisQuery')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->assertEquals('fuzzy_like_this', $fuzzyLikeThisQuery->getType());
    }

    /**
     * Tests if query accepts single field as string.
     */
    public function testSingleField()
    {
        $fuzzyLikeThisQuery = new FuzzyLikeThisQuery(
            'name.first',
            'text like this one',
            [ 'max_query_terms' => 12 ]
        );

        $this->assertSame(
            [
                'fields' => ['name.first'],
                'like_text' => 'text like this one',
                'max_query_terms' => 12,
            ],
            $fuzzyLikeThisQuery->toArray()
        );
    }
}
