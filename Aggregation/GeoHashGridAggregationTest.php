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

use ONGR\ElasticsearchBundle\DSL\Aggregation\GeoHashGridAggregation;

/**
 * Unit test for geohash grid aggregation.
 */
class GeoHashGridAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if exception is thrown.
     *
     * @expectedException \LogicException
     */
    public function testGeoHashGridAggregationException()
    {
        $agg = new GeoHashGridAggregation('test_agg');
        $agg->getArray();
    }
}
