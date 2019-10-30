<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use ONGR\ElasticsearchDSL\Query\TermLevel\TermsSetQuery;

class TermsSetQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $terms = ['php', 'c++', 'java'];
        $parameters = ['minimum_should_match_field' => 'required_matches'];
        $query = new TermsSetQuery('programming_languages', $terms, $parameters);
        $expected = [
            'terms_set' => [
                'programming_languages' => [
                    'terms' => ['php', 'c++', 'java'],
                    'minimum_should_match_field' => 'required_matches',
                ]
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

    public function testItThrowsAaExceptionWhenMinimumShouldMatchFieldOrMinimumShouldMatchScriptIsNotGiven()
    {
        $message = "Either minimum_should_match_field or minimum_should_match_script must be set.";
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        $terms = ['php', 'c++', 'java'];
        new TermsSetQuery('programming_languages', $terms, []);
    }
}
