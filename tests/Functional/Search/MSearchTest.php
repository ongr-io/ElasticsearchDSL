<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Functional;

use ONGR\ElasticsearchDSL\MSearch;
use ONGR\ElasticsearchDSL\Query\FullText\MatchQuery;
use ONGR\ElasticsearchDSL\Search;

class MSearchTest extends AbstractElasticsearchTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getDataArray()
    {
        return [
            'product' => [
                [
                    'title' => 'acme',
                ],
                [
                    'title' => 'foo',
                ],
            ]
        ];
    }

    /**
     * Match all test
     */
    public function testMultiSearch()
    {
        $mSearch = new MSearch();

        $search1 = new Search();
        $search1->addQuery(new MatchQuery('title', 'acme'));

        $search2 = new Search();
        $search2->addQuery(new MatchQuery('title', 'foo'));

        $mSearch
            ->addSearch($search1, ['index' => 'ongr-index-test'])
            ->addSearch($search2);


        $results = $this->executeMultiSearch($mSearch);

        $this->assertArrayHasKey('responses', $results);
    }
}
