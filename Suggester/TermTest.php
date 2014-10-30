<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Suggester;

use ONGR\ElasticsearchBundle\DSL\Suggester\Term;

class TermTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getTestToArrayData()
    {
        $out = [];

        // Case #0: simple.
        $term0 = new Term('body', 'lorem ipsum');
        $expected0 = [
            'body-term' => [
                'text' => 'lorem ipsum',
                'term' => [
                    'field' => 'body',
                ],
            ],
        ];
        $out[] = [$expected0, $term0];

        // Case #1: full suggester.
        $term1 = new Term('body', 'lorem ipsum');
        $term1
            ->setSize(2)
            ->setAnalyzer('simple')
            ->setSuggestMode(Term::SUGGEST_MODE_ALWAYS)
            ->setSort(Term::SORT_BY_SCORE);

        $expected1 = [
            'body-term' => [
                'text' => 'lorem ipsum',
                'term' => [
                    'field' => 'body',
                    'analyzer' => 'simple',
                    'sort' => 'score',
                    'suggest_mode' => 'always',
                ],
                'size' => 2,
            ],
        ];

        $out[] = [$expected1, $term1];

        return $out;
    }

    /**
     * Tests toArray method.
     *
     * @param array $expected
     * @param Term  $suggester
     *
     * @dataProvider getTestToArrayData
     */
    public function testToArray($expected, $suggester)
    {
        $this->assertEquals($expected, $suggester->toArray());
    }
}
