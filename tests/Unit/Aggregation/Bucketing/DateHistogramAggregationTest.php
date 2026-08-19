<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Tests\Unit\Bucketing\Aggregation;

use LogicException;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\DateHistogramAggregation;

/**
 * Unit test for children aggregation.
 */
class DateHistogramAggregationTest extends \PHPUnit\Framework\TestCase
{
    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->getArray();
    }

    public function testDateHistogramAggregationGetType(): void
    {
        $aggregation = new DateHistogramAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('date_histogram', $result);
    }

    public function testChildrenAggregationGetArray(): void
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
