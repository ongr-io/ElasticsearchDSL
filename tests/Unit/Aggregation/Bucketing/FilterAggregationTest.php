<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\FilterAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\HistogramAggregation;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\ExistsQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;

class FilterAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Data provider for testToArray.
     *
     * @return array
     */
    public function getToArrayData()
    {
        $out = [];

        // Case #0 filter aggregation.
        $aggregation = new FilterAggregation('test_agg');
        $filter = new MatchAllQuery();

        $aggregation->setFilter($filter);

        $result = [
            'filter' => $filter->toArray(),
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        // Case #1 nested filter aggregation.
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->setFilter($filter);

        $histogramAgg = new HistogramAggregation('acme', 'bar', 10);
        $aggregation->addAggregation($histogramAgg);

        $result = [
            'filter' => $filter->toArray(),
            'aggregations' => [
                $histogramAgg->getName() => $histogramAgg->toArray(),
            ],
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        // Case #2 testing bool filter.
        $aggregation = new FilterAggregation('test_agg');
        $matchAllFilter = new MatchAllQuery();
        $termFilter = new TermQuery('acme', 'foo');
        $boolFilter = new BoolQuery();
        $boolFilter->add($matchAllFilter);
        $boolFilter->add($termFilter);

        $aggregation->setFilter($boolFilter);

        $result = [
            'filter' => $boolFilter->toArray(),
        ];


        $out[] = [
            $aggregation,
            $result,
        ];

        return $out;
    }

    /**
     * Test for filter aggregation toArray() method.
     *
     * @param FilterAggregation $aggregation
     * @param array             $expectedResult
     *
     * @dataProvider getToArrayData
     */
    public function testToArray($aggregation, $expectedResult)
    {
        $this->assertEquals($expectedResult, $aggregation->toArray());
    }

    /**
     * Test for setField().
     */
    public function testSetField()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('doesn\'t support `field` parameter');
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->setField('test_field');
    }

    /**
     * Test for toArray() without setting a filter.
     */
    public function testToArrayNoFilter()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('has no filter added');
        $aggregation = new FilterAggregation('test_agg');
        $result = $aggregation->toArray();

        $this->assertEquals(
            [
                'aggregation' => [
                    'test_agg' => [
                        'filter' => []
                    ]
                ]
            ],
            $result
        );
    }

    /**
     * Test for toArray() with setting a filter.
     */
    public function testToArrayWithFilter()
    {
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->setFilter(new ExistsQuery('test'));
        $result = $aggregation->toArray();

        $this->assertEquals(
            [
                'filter' => [
                    'exists' => [
                        'field' => 'test'
                    ]
                ]
            ],
            $result
        );
    }

    /**
     * Tests if filter can be passed to constructor.
     */
    public function testConstructorFilter()
    {
        $matchAllFilter = new MatchAllQuery();
        $aggregation = new FilterAggregation('test', $matchAllFilter);
        $this->assertEquals(
            [
                'filter' => $matchAllFilter->toArray(),
            ],
            $aggregation->toArray()
        );
    }
}
