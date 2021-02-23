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

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\AutoDateHistogramAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\TermsAggregation;

class AudoDateHistogramAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests agg.
     */
    public function testAutoDateHistogramAggregationSetField()
    {
        // Case #0 terms aggregation.
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'test_field');

        $result = [
            'auto_date_histogram' => ['field' => 'test_field'],
        ];

        $this->assertEquals($aggregation->toArray(), $result);
    }

    /**
     * Tests setSize method.
     */
    public function testAutoDateHistogramAggregationFormat()
    {
        $date = '2020-12-25';
        // Case #1
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'test_field');
        $aggregation->addParameter('format', $date);

        $result = [
            'auto_date_histogram' => [
                'field' => 'test_field',
                'format' => $date,

            ],
        ];

        $this->assertEquals($aggregation->toArray(), $result);

        // Case #2
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'test_field', null, $date);

        $result = [
            'auto_date_histogram' => [
                'field' => 'test_field',
                'format' => $date,
            ],
        ];

        $this->assertEquals($aggregation->toArray(), $result);
    }

    /**
     * Tests buckets.
     */
    public function testAutoDateHistogramAggregationBuckets()
    {
        // Case #1
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'wrong_field');
        $aggregation->setField('test_field');

        $aggregation->addParameter('buckets', 5);

        $result = [
            'auto_date_histogram' => [
                'field' => 'test_field',
                'buckets' => 5,
            ],
        ];

        $this->assertEquals($aggregation->toArray(), $result);

        // Case #2
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'wrong_field', 5);
        $aggregation->setField('test_field');

        $result = [
            'auto_date_histogram' => [
                'field' => 'test_field',
                'buckets' => 5,
            ],
        ];

        $this->assertEquals($aggregation->toArray(), $result);
    }

    /**
     * Tests getType method.
     */
    public function testAutoDateHistogramAggregationGetType()
    {
        $aggregation = new AutoDateHistogramAggregation('foo', 'bar');
        $result = $aggregation->getType();
        $this->assertEquals('auto_date_histogram', $result);
    }
}
