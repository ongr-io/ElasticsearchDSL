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

use ONGR\ElasticsearchDSL\Filter\RegexpFilter;

class RegexpFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new RegexpFilter('', '\w', []);
        $this->assertEquals('regexp', $filter->getType());
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
            ['', '\w', [], ['' => ['value' => '\w']]],
            // Case #2.
            ['regexp', '\w', ['flags' => 'foo'], ['regexp' => ['value' => '\w', 'flags' => 'foo']]],
        ];
    }

    /**
     * Test for filter toArray() method.
     *
     * @param string $field      Field name.
     * @param string $regexp     Regular expression.
     * @param array  $parameters Optional parameters.
     * @param array  $expected   Expected values.
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray($field, $regexp, $parameters, $expected)
    {
        $filter = new RegexpFilter($field, $regexp, $parameters);
        $result = $filter->toArray();
        $this->assertEquals($expected, $result);
    }
}
