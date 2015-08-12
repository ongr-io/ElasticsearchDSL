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

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\FilterAggregation;
use ONGR\ElasticsearchDSL\Aggregation\HistogramAggregation;
use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Filter\BoolFilter;
use ONGR\ElasticsearchDSL\Filter\MatchAllFilter;
use ONGR\ElasticsearchDSL\Filter\MissingFilter;
use ONGR\ElasticsearchDSL\Filter\TermFilter;

class FilterAggregationTest extends \PHPUnit_Framework_TestCase
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
        $filter = new MatchAllFilter();

        $aggregation->setFilter($filter);

        $result = [
            'filter' => [
                $filter->getType() => $filter->toArray(),
            ],
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
            'filter' => [
                $filter->getType() => $filter->toArray(),
            ],
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
        $matchAllFilter = new MatchAllFilter();
        $termFilter = new TermFilter('acme', 'foo');
        $boolFilter = new BoolFilter();
        $boolFilter->add($matchAllFilter);
        $boolFilter->add($termFilter);

        $aggregation->setFilter($boolFilter);

        $result = [
            'filter' => [
                $boolFilter->getType() => $boolFilter->toArray(),
            ],
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
     *
     * @expectedException        \LogicException
     * @expectedExceptionMessage doesn't support `field` parameter
     */
    public function testSetField()
    {
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->setField('test_field');
    }

    /**
     * Test for toArray() without setting a filter.
     *
     * @expectedException        \LogicException
     * @expectedExceptionMessage has no filter added
     */
    public function testToArrayNoFilter()
    {
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->toArray();
    }

    /**
     * Test for toArray() with setting a filter.
     */
    public function testToArrayWithFilter()
    {
        $aggregation = new FilterAggregation('test_agg');

        $aggregation->setFilter(new MissingFilter('test'));
        $aggregation->toArray();
    }

    /**
     * Tests if filter can be passed to constructor.
     */
    public function testConstructorFilter()
    {
        $matchAllFilter = new MatchAllFilter();
        $aggregation = new FilterAggregation('test', $matchAllFilter);
        $this->assertSame(
            [
                'filter' => [
                    $matchAllFilter->getType() => $matchAllFilter->toArray(),
                ],
            ],
            $aggregation->toArray()
        );
    }
}
