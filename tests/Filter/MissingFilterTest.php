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

use ONGR\ElasticsearchDSL\Filter\MissingFilter;

class MissingFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new MissingFilter('', []);
        $this->assertEquals('missing', $filter->getType());
    }

    /**
     * Data provider to testGetToArray.
     *
     * @return array
     */
    public function getArrayDataProvider()
    {
        return [
            // Case 1.
            ['', [], ['field' => '']],
            // Case 2.
            ['user', ['bar' => 'foo'], ['field' => 'user', 'bar' => 'foo']],
        ];
    }

    /**
     * Test for filter toArray() method.
     *
     * @param string $field
     * @param array  $parameters
     * @param array  $expected
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray($field, $parameters, $expected)
    {
        $filter = new MissingFilter($field, $parameters);
        $result = $filter->toArray();
        $this->assertEquals($expected, $result);
    }
}
