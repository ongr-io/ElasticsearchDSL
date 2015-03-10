<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Filter;

use ONGR\ElasticsearchBundle\DSL\Filter\GeoPolygonFilter;

class GeoPolygonFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new GeoPolygonFilter('test_field');
        $result = $filter->getType();
        $this->assertEquals('geo_polygon', $result);
    }
}
