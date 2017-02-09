<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace ONGR\ElasticsearchDSL\Tests\Unit;


use Elasticsearch\Common\Exceptions\InvalidArgumentException;
use ONGR\ElasticsearchDSL\MSearch;
use ONGR\ElasticsearchDSL\Query\FullText\MatchQuery;
use ONGR\ElasticsearchDSL\Search;

class MSearchTest extends \PHPUnit_Framework_TestCase
{

    public function testAddSearchOnSameIndex()
    {
        $mSearch = new MSearch();

        $search1 = new Search();
        $search1->addQuery(new MatchQuery('field', 'value'));

        $search2 = new Search();
        $search2->addQuery(new MatchQuery('secondField', 'secondValue'));

        $mSearch
            ->addSearch($search1, ['index' => 'ongr-index-test'])
            ->addSearch($search2);

        $result = $mSearch->toArray();

        $this->assertArraySubset([
            ['index' => 'ongr-index-test'],
            [
                'query' =>
                [
                    'match' =>
                        [
                            'field' => ['query' => 'value']
                        ]
                ]
            ],
            [],
            [
                'query' =>
                [
                    'match' => [
                        'secondField' => ['query' => 'secondValue']
                    ]
                ]
            ]
        ], $result);
    }


    public function testUnsupportedOption()
    {
        $this->expectException(InvalidArgumentException::class);

        $mSearch = new MSearch();

        $search1 = new Search();
        $search1->addQuery(new MatchQuery('field', 'value'));

        $mSearch->addSearch($search1, ['not_existing_property' => 'value']);
    }


}
