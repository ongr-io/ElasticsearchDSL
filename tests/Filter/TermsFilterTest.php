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

use ONGR\ElasticsearchDSL\Filter\TermsFilter;

class TermsFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new TermsFilter('', [], []);
        $result = $filter->getType();
        $this->assertEquals('terms', $result);
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
            ['tags', ['foo', 'bar'], [], ['tags' => [0 => 'foo', 1 => 'bar']]],
            // Case #3.
            ['tags', ['foo', 'bar'], ['type' => 'acme'], ['tags' => [0 => 'foo', 1 => 'bar'], 'type' => 'acme']],
        ];
    }

    /**
     * Test for filter toArray() method.
     *
     * @param string $field      Field name.
     * @param array  $terms      An array of terms.
     * @param array  $parameters Optional parameters.
     * @param array  $expected   Expected values.
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray($field, $terms, $parameters, $expected)
    {
        $filter = new TermsFilter($field, $terms, $parameters);
        $result = $filter->toArray();
        $this->assertEquals($expected, $result);
    }
}
