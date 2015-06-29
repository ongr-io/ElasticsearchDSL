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
            ['foo', [1, 5], [], ['foo' => [0 => 1, 1 => 5]]],
            // Case #3.
            ['test', ['foo', 'bar'], ['type' => 'acme'], ['test' => [0 => 'foo', 1 => 'bar'], 'type' => 'acme']],
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
