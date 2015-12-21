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

use ONGR\ElasticsearchDSL\Filter\RangeFilter;

class RangeFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new RangeFilter('', [], []);
        $this->assertEquals('range', $filter->getType());
    }

    /**
     * Data provider to testGetToArray.
     *
     * @return array
     */
    public function getArrayDataProvider()
    {
        return [
            // Case #1.
            ['', [], [], ['' => []]],
            // Case #2.
            ['foo', ['gte' => 1, 'lte' => 5], [], ['foo' => ['gte' => 1, 'lte' => 5]]],
            // Case #3.
            [
                'test',
                ['gte' => 1, 'lte' => 5],
                ['type' => 'acme'],
                ['test' => ['gte' => 1, 'lte' => 5, 'type' => 'acme']]
            ],
        ];
    }

    /**
     * Test for filter toArray() method.
     *
     * @param string $field      Field name.
     * @param array  $range      Range values.
     * @param array  $parameters Optional parameters.
     * @param array  $expected   Expected result.
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray($field, $range, $parameters, $expected)
    {
        $filter = new RangeFilter($field, $range, $parameters);
        $result = $filter->toArray();
        $this->assertEquals($expected, $result);
    }
}
