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

use ONGR\ElasticsearchDSL\Filter\PrefixFilter;

class PrefixFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new PrefixFilter('', '', []);
        $result = $filter->getType();
        $this->assertEquals('prefix', $result);
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
            ['', '', [], ['' => '']],
            // Case #2.
            ['prefix', 'foo', [], ['prefix' => 'foo']],
            // Case #3.
            ['prefix', 'foo', ['type' => 'acme'], ['prefix' => 'foo', 'type' => 'acme']],
        ];
    }

    /**
     * Test for filter toArray() method.
     *
     * @param string $field      Field name.
     * @param string $value      Field value.
     * @param array  $parameters Optional parameters.
     * @param array  $expected   Expected values.
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray($field, $value, $parameters, $expected)
    {
        $filter = new PrefixFilter($field, $value, $parameters);
        $result = $filter->toArray();
        $this->assertEquals($expected, $result);
    }
}
