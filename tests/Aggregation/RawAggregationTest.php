<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\RangeAggregation;
use ONGR\ElasticsearchDSL\Aggregation\RawAggregation;
use ONGR\ElasticsearchDSL\Aggregation\TermsAggregation;
use ONGR\ElasticsearchDSL\Aggregation\SumAggregation;

class RawAggregationTest extends \PHPUnit_Framework_TestCase
{
    public function testRawAggregation()
    {
        $aggregation = new TermsAggregation('foo', 'bar');
        $rawAggregation = new RawAggregation('foo', 'terms', ['field' => 'bar']);

        $this->assertEquals($aggregation->toArray(), $rawAggregation->toArray());
    }

    public function testRawAggregationNesting()
    {
        $rangeAgg = new RangeAggregation('foo', 'bar');
        $rangeAgg->addRange(10, 20);
        $rangeAgg->addAggregation(new SumAggregation('nested', 'acme'));

        $rangeAggArray = [
            'field' => 'bar',
            'keyed' => false,
            'ranges' => [
                [
                    'from' => 10,
                    'to' => 20,
                ],
            ],
        ];

        $rawAggregation = new RawAggregation('foo', 'range', $rangeAggArray);
        $rawAggregation->addAggregation(new SumAggregation('nested', 'acme'));

        $this->assertEquals($rangeAgg->toArray(), $rawAggregation->toArray());
    }
}
