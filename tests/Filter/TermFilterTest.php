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

use ONGR\ElasticsearchDSL\Filter\TermFilter;

class TermFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new TermFilter('', '', []);
        $result = $filter->getType();
        $this->assertEquals('term', $result);
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
            ['term', 'foo', [], ['term' => 'foo']],
            // Case #3.
            ['term', 'foo', ['type' => 'acme'], ['term' => 'foo', 'type' => 'acme']],
        ];
    }

    /**
     * Test for filter toArray() method.
     *
     * @param string $field      Field name.
     * @param string $term       Field value.
     * @param array  $parameters Optional parameters.
     * @param array  $expected   Expected values.
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray($field, $term, $parameters, $expected)
    {
        $filter = new TermFilter($field, $term, $parameters);
        $result = $filter->toArray();
        $this->assertEquals($expected, $result);
    }
}
