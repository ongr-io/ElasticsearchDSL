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
use ONGR\ElasticsearchDSL\Sort\FieldSort;
use ONGR\ElasticsearchDSL\Sort\NestedSort;

class FieldSortTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test for toArray() method.
     *
     */
    public function testToArray()
    {
        $nestedFilter = new NestedSort('somePath', new TermQuery('somePath.id', 10));
        $sort = new FieldSort('someField', 'asc');
        $sort->setNestedFilter($nestedFilter);

        $expected = [
            'someField' => [
                'nested' => [
                    'path'   => 'somePath',
                    'filter' => [
                        'term' => [
                            'somePath.id' => 10,
                        ]
                    ]
                ],
                'order'  => 'asc'
            ],
        ];
        $result = $sort->toArray();
        $this->assertEquals($expected, $result);
    }
}
