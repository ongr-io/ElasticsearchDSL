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

use ONGR\ElasticsearchDSL\Suggest\ContextSuggest;

class ContextSuggestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests getType method.
     */
    public function testSuggestGetType()
    {
        $suggest = new ContextSuggest('foo', 'bar', ['foo' => 'bar']);
        $result = $suggest->getType();
        $this->assertEquals('context_suggest', $result);
    }

    /**
     * Tests toArray() method.
     */
    public function testSuggestWithoutFieldAndSize()
    {
        // Case #1 suggest without field and size params.
        $suggest = new ContextSuggest('foo', 'bar', ['color' => 'red']);
        $expected = [
            'foo' => [
                'text' => 'bar',
                'completion' => [
                    'field' => '_all',
                    'size' => 3,
                    'context' => [
                        'color' => 'red'
                    ]
                ]
            ]
        ];
        $this->assertEquals($expected, $suggest->toArray());
    }

    /**
     * Tests toArray() method.
     */
    public function testToArray()
    {
        $suggest = new ContextSuggest(
            'foo',
            'bar',
            [
                'color' => 'red'
            ],
            [
                'size' => 5,
                'field' => 'title',
                'analyzer' => 'whitespace',
            ]
        );
        $expected = [
            'foo' => [
                'text' => 'bar',
                'completion' => [
                    'field' => 'title',
                    'size' => 5,
                    'analyzer' => 'whitespace',
                    'context' => [
                        'color' => 'red'
                    ]
                ]
            ]
        ];
        $this->assertEquals($expected, $suggest->toArray());
    }
}
