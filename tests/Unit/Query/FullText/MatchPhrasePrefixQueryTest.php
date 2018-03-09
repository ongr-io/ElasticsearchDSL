<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\FullText;

use ONGR\ElasticsearchDSL\Query\FullText\MatchPhrasePrefixQuery;
use PHPUnit\Framework\TestCase;

class MatchPhrasePrefixQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $query = new MatchPhrasePrefixQuery('message', 'this is a test');
        $expected = [
            'match_phrase_prefix' => [
                'message' => [
                    'query' => 'this is a test',
                ],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
