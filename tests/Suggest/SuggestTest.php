<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Suggest;

use ONGR\ElasticsearchDSL\Suggest\Suggest;

class SuggestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests getType method.
     */
    public function testSuggestGetType()
    {
        $suggest = new Suggest('foo', 'bar', Suggest::TERM, 'acme');
        $this->assertEquals('term', $suggest->getType());
    }

    /**
     * Data provider for testToArray()
     *
     * @return array[]
     */
    public function getTestToArrayData()
    {
        return [
            [
                'suggest' => new Suggest(
                    'foo',
                    'acme',
                    Suggest::PHRASE,
                    'bar',
                    ['max_errors' => 0.5]
                ),
                'expected' => [
                    'foo' => [
                        'text' => 'bar',
                        'phrase' => [
                            'field' => 'acme',
                            'max_errors' => 0.5,
                        ],
                    ]
                ]
            ],
            [
                'suggest' => new Suggest(
                    'foo',
                    'acme',
                    Suggest::CONTEXT,
                    'bar',
                    ['context' => ['color' => 'red'], 'size' => 3]
                ),
                'expected' => [
                    'foo' => [
                        'text' => 'bar',
                        'completion' => [
                            'field' => 'acme',
                            'size' => 3,
                            'context' => [
                                'color' => 'red'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'suggest' => new Suggest(
                    'foo',
                    'acme',
                    Suggest::TERM,
                    'bar',
                    ['size' => 5]
                ),
                'expected' => [
                    'foo' => [
                        'text' => 'bar',
                        'term' => [
                            'field' => 'acme',
                            'size' => 5
                        ]
                    ]
                ]
            ],
            [
                'suggest' => new Suggest(
                    'foo',
                    'acme',
                    Suggest::COMPLETION,
                    'bar'
                ),
                'expected' => [
                    'foo' => [
                        'text' => 'bar',
                        'completion' => [
                            'field' => 'acme'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @param Suggest $suggest
     * @param array $expected
     *
     * @dataProvider getTestToArrayData()
     */
    public function testToArray(Suggest $suggest, array $expected)
    {
        $this->assertEquals($expected, $suggest->toArray());
    }

    /**
     * Tests exception that is thrown when wrong type is provided
     *
     * @expectedException \InvalidArgumentException
     */
    public function testValidateTypeException()
    {
        new Suggest('foo', 'bar', 'wrong-type', 'acme');
    }
}
