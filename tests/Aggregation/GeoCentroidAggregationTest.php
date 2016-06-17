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

use ONGR\ElasticsearchDSL\Aggregation\GeoCentroidAggregation;

/**
 * Unit test for children aggregation.
 */
class GeoCentroidAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests if ChildrenAggregation#getArray throws exception when expected.
     *
     * @expectedException \LogicException
     */
    public function testGetArrayException()
    {
        $aggregation = new GeoCentroidAggregation('foo');
        $aggregation->getArray();
    }

    /**
     * Tests getType method.
     */
    public function testGeoCentroidAggregationGetType()
    {
        $aggregation = new GeoCentroidAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('geo_centroid', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testGeoCentroidAggregationGetArray()
    {
        $aggregation = new GeoCentroidAggregation('foo');
        $aggregation->setField('location');
        $result = $aggregation->getArray();
        $expected = ['field' => 'location'];
        $this->assertEquals($expected, $result);
    }
}
