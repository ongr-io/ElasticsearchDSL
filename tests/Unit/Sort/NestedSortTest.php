<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Sort;

use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use ONGR\ElasticsearchDSL\Sort\NestedSort;

class NestedSortTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test for single nested.
     *
     */
    public function testSingle()
    {
        $query = new NestedSort('somePath', new TermQuery('somePath.id', 10));
        $expected = [
            'path'   => 'somePath',
            'filter' => [
                'term' => [
                    'somePath.id' => 10,
                ]
            ]
        ];
        $result = $query->toArray();
        $this->assertEquals($expected, $result);
    }

    /**
     * Test for single nested, no filter.
     *
     */
    public function testNoFilter()
    {
        $query = new NestedSort('somePath');
        $expected = [
            'path'   => 'somePath',
        ];
        $result = $query->toArray();
        $this->assertEquals($expected, $result);
    }

    /**
     * Test for single nested.
     *
     */
    public function testMultipleNesting()
    {
        $query = new NestedSort('somePath', new TermQuery('somePath.id', 10));
        $nestedFilter1 = new NestedSort('secondPath', new TermQuery('secondPath.foo', 'bar'));
        $nestedFilter2 = new NestedSort('thirdPath', new TermQuery('thirdPath.x', 'y'));
        $nestedFilter1->setNestedFilter($nestedFilter2);
        $query->setNestedFilter($nestedFilter1);
        $expected = [
            'path'   => 'somePath',
            'filter' => [
                'term' => [
                    'somePath.id' => 10,
                ]
            ],
            'nested' => [
                'path'   => 'secondPath',
                'filter' => [
                    'term' => [
                        'secondPath.foo' => 'bar',
                    ]
                ],
                'nested' => [
                    'path'   => 'thirdPath',
                    'filter' => [
                        'term' => [
                            'thirdPath.x' => 'y',
                        ]
                    ],
                ]
            ]
        ];
        $result = $query->toArray();
        $this->assertEquals($expected, $result);
    }
}
