<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Bucketing\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\DateHistogramAggregation;

/**
 * Unit test for children aggregation.
 */
class DateHistogramAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests if ChildrenAggregation#getArray throws exception when expected.
     *
     * @expectedException \LogicException
     */
    public function testGetArrayException()
    {
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->getArray();
    }

    /**
     * Tests getType method.
     */
    public function testDateHistogramAggregationGetType()
    {
        $aggregation = new DateHistogramAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('date_histogram', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testChildrenAggregationGetArray()
    {
        $mock = $this->getMockBuilder('ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->addAggregation($mock);
        $aggregation->setField('date');
        $aggregation->setInterval('month');
        $result = $aggregation->getArray();
        $expected = ['field' => 'date', 'interval' => 'month'];
        $this->assertEquals($expected, $result);
    }
}
