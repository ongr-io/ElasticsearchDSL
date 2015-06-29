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

use ONGR\ElasticsearchDSL\Aggregation\DateRangeAggregation;

class DateRangeAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if exception is thrown.
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage Date range aggregation must have field, format set and range added.
     */
    public function testIfExceptionIsThrownWhenNoParametersAreSet()
    {
        $agg = new DateRangeAggregation('test_agg');
        $agg->getArray();
    }

    /**
     * Test if exception is thrown when both range parameters are null.
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage Either from or to must be set. Both cannot be null.
     */
    public function testIfExceptionIsThrownWhenBothRangesAreNull()
    {
        $agg = new DateRangeAggregation('test_agg');
        $agg->addRange(null, null);
    }

    /**
     * Test getArray method.
     */
    public function testDateRangeAggregationGetArray()
    {
        $agg = new DateRangeAggregation('foo');
        $agg->addRange(10, 20);
        $agg->setFormat('bar');
        $agg->setField('baz');
        $result = $agg->getArray();
        $expected = [
            'format' => 'bar',
            'field' => 'baz',
            'ranges' => [['from' => 10, 'to' => 20]],
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests getType method.
     */
    public function testDateRangeAggregationGetType()
    {
        $aggregation = new DateRangeAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('date_range', $result);
    }
}
