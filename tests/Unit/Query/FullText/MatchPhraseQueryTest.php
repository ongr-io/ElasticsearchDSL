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

use ONGR\ElasticsearchDSL\Query\FullText\MatchPhraseQuery;
use PHPUnit\Framework\TestCase;

class MatchPhraseQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $query = new MatchPhraseQuery('message', 'this is a test');
        $expected = [
            'match_phrase' => [
                'message' => [
                    'query' => 'this is a test',
                ],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
