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

use ONGR\ElasticsearchBundle\DSL\Aggregation\GeoBoundsAggregation;

/**
 * Unit test for geo bounds aggregation.
 */
class GeoBoundsAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if exception is thrown.
     *
     * @expectedException \LogicException
     */
    public function testGeoBoundsAggregationException()
    {
        $agg = new GeoBoundsAggregation('test_agg');
        $agg->getArray();
    }

    /**
     * Tests getType method.
     */
    public function testGeoBoundsAggregationGetType()
    {
        $agg = new GeoBoundsAggregation('foo');
        $result = $agg->getType();
        $this->assertEquals('geo_bounds', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testGeoBoundsAggregationGetArray()
    {
        $agg = new GeoBoundsAggregation('foo');
        $agg->setField('bar');
        $agg->setWrapLongitude(false);
        $result = $agg->getArray();
        $this->assertArrayHasKey('field', $result);
        $this->assertArrayHasKey('wrap_longitude', $result);
        $this->assertEquals('bar', $result['field']);
        $this->assertFalse($result['wrap_longitude']);
        $agg->setWrapLongitude(true);
        $result = $agg->getArray();
        $this->assertTrue($result['wrap_longitude']);
    }
}
