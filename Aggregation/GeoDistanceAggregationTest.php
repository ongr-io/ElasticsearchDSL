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

use ONGR\ElasticsearchBundle\DSL\Aggregation\GeoDistanceAggregation;

class GeoDistanceAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if exception is thrown when field is not set.
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage Geo distance aggregation must have a field set.
     */
    public function testGeoDistanceAggregationExceptionWhenFieldIsNotSet()
    {
        $agg = new GeoDistanceAggregation('test_agg');
        $agg->setOrigin('50, 70');
        $agg->getArray();
    }

    /**
     * Test if exception is thrown when origin is not set.
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage Geo distance aggregation must have an origin set.
     */
    public function testGeoDistanceAggregationExceptionWhenOriginIsNotSet()
    {
        $agg = new GeoDistanceAggregation('test_agg');
        $agg->setField('location');
        $agg->getArray();
    }

    /**
     * Test if exception is thrown when field is not set.
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage Either from or to must be set. Both cannot be null.
     */
    public function testGeoDistanceAggregationAddRangeException()
    {
        $agg = new GeoDistanceAggregation('test_agg');
        $agg->addRange();
    }
}
