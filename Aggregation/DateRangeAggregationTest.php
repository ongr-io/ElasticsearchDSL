<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Aggregation;

use ONGR\ElasticsearchBundle\DSL\Aggregation\DateRangeAggregation;

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
}
