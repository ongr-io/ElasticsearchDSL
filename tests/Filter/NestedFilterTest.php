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

use ONGR\ElasticsearchDSL\Filter\NestedFilter;
use ONGR\ElasticsearchDSL\Filter\TermFilter;
use ONGR\ElasticsearchDSL\Filter\TermsFilter;

class NestedFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new NestedFilter('', new TermFilter('foo', 'bar'));
        $this->assertEquals('nested', $filter->getType());
    }

    /**
     * Data provider to testGetToArray.
     *
     * @return array
     */
    public function getArrayDataProvider()
    {
        $filter = [
            'terms' => [
                'foo' => 'bar',
            ],
        ];

        return [
            // Case #0 Basic filter.
            [
                'product.sub_item',
                [],
                ['path' => 'product.sub_item', 'filter' => $filter],
            ],
            // Case #1 with parameters.
            [
                'product.sub_item',
                ['_cache' => true, '_name' => 'named_result'],
                [
                    'path' => 'product.sub_item',
                    'filter' => $filter,
                    '_cache' => true,
                    '_name' => 'named_result',
                ],
            ],
        ];
    }

    /**
     * Test for filter toArray() method.
     *
     * @param string $path
     * @param array  $parameters
     * @param array  $expected
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray($path, $parameters, $expected)
    {
        $query = new TermsFilter('foo', 'bar');
        $filter = new NestedFilter($path, $query, $parameters);
        $result = $filter->toArray();
        $this->assertEquals($expected, $result);
    }
}
