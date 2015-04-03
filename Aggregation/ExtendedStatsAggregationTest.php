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

use ONGR\ElasticsearchBundle\DSL\Aggregation\ExtendedStatsAggregation;

class ExtendedStatsAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests if exception is thrown when expected.
     *
     * @expectedException \LogicException
     */
    public function testExtendedStatsAggregationGetArrayException()
    {
        $agg = new ExtendedStatsAggregation('foo');
        $agg->getArray();
    }
}
