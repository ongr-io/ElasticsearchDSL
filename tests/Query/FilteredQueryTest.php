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

use ONGR\ElasticsearchDSL\Query\FilteredQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Query\TermQuery;

/**
 * Unit test for Filtered.
 */
class FilteredQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests toArray() method.
     */
    public function testFilteredToArray()
    {
        $filtered = new FilteredQuery(
            new MatchAllQuery(),
            new TermQuery('foo', 'bar')
        );
        $expected = [
            'filtered' => [
                'query' => [
                    'match_all' => []
                ],
                'filter' => [
                    'term' => [
                        'foo' => 'bar'
                    ]
                ]
            ],
        ];
        $this->assertEquals($expected, $filtered->toArray());
    }

    /**
     * Tests bool query in filter context.
     */
    public function testGetType()
    {
        $filtered = new FilteredQuery();
        $this->assertEquals('filtered', $filtered->getType());
    }
}
