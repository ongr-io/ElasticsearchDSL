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

use ONGR\ElasticsearchBundle\DSL\Suggester\Completion;

class CompletionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getTestToArrayData()
    {
        $out = [];

        // Case #0: simple.
        $completion0 = new Completion('my-field', 'lorem ipsum');
        $expected0 = [
            'my-field-completion' => [
               'text' => 'lorem ipsum',
                'completion' => [
                    'field' => 'my-field',
                ],
            ],
        ];

        $out[] = [$expected0, $completion0];

        // Case #1: using fuzzy.
        $completion1 = new Completion('my-other-field', 'super awesome cat', 'my-completion1');
        $completion1->useFuzzy(true);
        $expected1 = [
            'my-completion1' => [
                'text' => 'super awesome cat',
                'completion' => [
                    'field' => 'my-other-field',
                    'fuzzy' => true,
                ],
            ],
        ];

        $out[] = [$expected1, $completion1];

        // Case #2: providing all data.
        $completion2 = new Completion('body', 'even more super awesome cat', 'my-completion2');
        $completion2
            ->setFuzziness(2)
            ->setMinLength(3)
            ->setPrefixLength(1)
            ->setTranspositions(true)
            ->setUnicodeAware('');

        $expected2 = [
            'my-completion2' => [
                'text' => 'even more super awesome cat',
                'completion' => [
                    'field' => 'body',
                    'fuzzy' => [
                        'fuzziness' => 2,
                        'transpositions' => true,
                        'min_length' => 3,
                        'prefix_length' => 1,
                    ],
                ],
            ],
        ];

        $out[] = [$expected2, $completion2];

        return $out;
    }

    /**
     * Tests toArray method.
     *
     * @param array      $expected
     * @param Completion $phrase
     *
     * @dataProvider getTestToArrayData
     */
    public function testToArray($expected, $phrase)
    {
        $this->assertEquals($expected, $phrase->toArray());
    }
}
