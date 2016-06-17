<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Query;

use ONGR\ElasticsearchDSL\Query\NotQuery;
use ONGR\ElasticsearchDSL\Query\TermQuery;

/**
 * Unit test for Not.
 */
class NotQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests toArray() method.
     */
    public function testNotToArray()
    {
        $not = new NotQuery(new TermQuery('foo', 'bar'));
        $expected = [
            'not' => [
                'term' => [
                    'foo' => 'bar'
                ]
            ],
        ];
        $this->assertEquals($expected, $not->toArray());
    }

    /**
     * Tests getType() method
     */
    public function testGetType()
    {
        $not = new NotQuery(new TermQuery('foo', 'bar'));
        $this->assertEquals('not', $not->getType());
    }
}
