<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Functional\Query;

use ONGR\ElasticsearchDSL\Query\Compound\FunctionScoreQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Tests\Functional\AbstractElasticsearchTestCase;

class FunctionScoreQueryTest extends AbstractElasticsearchTestCase
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
                    'price' => 10,
                ],
                [
                    'title' => 'foo',
                    'price' => 20,
                ],
                [
                    'title' => 'bar',
                    'price' => 10,
                ],
            ]
        ];
    }

    /**
     * Match all test
     */
    public function testRandomScore()
    {
        $fquery = new FunctionScoreQuery(new MatchAllQuery());
        $fquery->addRandomFunction();
        $fquery->addParameter('boost_mode', 'multiply');

        $search = new Search();
        $search->addQuery($fquery);
        $results = $this->executeSearch($search);

        $this->assertEquals(count($this->getDataArray()['product']), count($results));
    }

    public function testScriptScore()
    {
        $fquery = new FunctionScoreQuery(new MatchAllQuery());
        $fquery->addScriptScoreFunction(
            "
            if (doc['price'].value < params.target) 
             {
               return doc['price'].value * params.charge; 
             }
             return doc['price'].value;
             ",
            [
                'target' => 10,
                'charge' => 0.9,
            ]
        );

        $search = new Search();
        $search->addQuery($fquery);
        $results = $this->executeSearch($search);

        foreach ($results as $document) {
            $this->assertLessThanOrEqual(20, $document['price']);
        }
    }
}
