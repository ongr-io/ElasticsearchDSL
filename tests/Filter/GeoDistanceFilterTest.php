<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Filter;

use ONGR\ElasticsearchDSL\Filter\GeoDistanceFilter;

class GeoDistanceFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new GeoDistanceFilter('test_field', 'test_distance', 'test_location');
        $result = $filter->getType();
        $this->assertEquals('geo_distance', $result);
    }

    /**
     * Data provider to testToArray.
     *
     * @return array
     */
    public function getArrayDataProvider()
    {
        return [
            // Case #1.
            [
                'location',
                '200km',
                ['lat' => 40, 'lon' => -70],
                [],
                ['distance' => '200km', 'location' => ['lat' => 40, 'lon' => -70]],
            ],
            // Case #2.
            [
                'location',
                '20km',
                ['lat' => 0, 'lon' => 0],
                ['parameter' => 'value'],
                ['distance' => '20km', 'location' => ['lat' => 0, 'lon' => 0], 'parameter' => 'value'],
            ],
        ];
    }

    /**
     * Tests toArray method.
     *
     * @param string $field      Field name.
     * @param string $distance   Distance.
     * @param array  $location   Location.
     * @param array  $parameters Optional parameters.
     * @param array  $expected   Expected result.
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray($field, $distance, $location, $parameters, $expected)
    {
        $filter = new GeoDistanceFilter($field, $distance, $location, $parameters);
        $result = $filter->toArray();
        $this->assertEquals($expected, $result);
    }
}
