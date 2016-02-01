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
        $suggest = new Suggest('foo', 'bar');
        $result = $suggest->getType();
        $this->assertEquals('suggest', $result);
    }

    /**
     * Tests toArray() method.
     */
    public function testSuggestWithoutFieldAndSize()
    {
        // Case #1 suggest without field and size params.
        $suggest = new Suggest('foo', 'bar');
        $expected = [
            'text' => 'bar',
            'term' => [
                'field' => '_all',
                'size' => 3,
            ],
        ];
        $this->assertEquals($expected, $suggest->toArray());
    }

    /**
     * Tests toArray() method.
     */
    public function testToArray()
    {
        $suggest = new Suggest(
            'foo',
            'bar',
            [
                'size' => 5,
                'field' => 'title',
                'analyzer' => 'whitespace',
            ]
        );
        $expected = [
            'text' => 'bar',
            'term' => [
                'field' => 'title',
                'size' => 5,
                'analyzer' => 'whitespace',
            ],
        ];
        $this->assertEquals($expected, $suggest->toArray());
    }
}
