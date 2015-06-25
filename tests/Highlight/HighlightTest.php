<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Highlight;

use ONGR\ElasticsearchBundle\DSL\Highlight\Field;
use ONGR\ElasticsearchBundle\DSL\Highlight\Highlight;

/**
 * Unit test for Highlight.
 */
class HighlightTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests toArray method.
     */
    public function testHighlightToArray()
    {
        $highlight = new Highlight([new Field('name')]);
        $highlight->setOrder('test');
        $highlight->setHighlighterType('postings');
        $highlight->setFragmentSize(5);
        $highlight->setNumberOfFragments(5);
        $highlight->setTagsSchema('styled');
        $highlight->setTag('tag', 'class');
        $highlight->setTag('only_tag');

        $result = [
            'order' => 'test',
            'type' => 'postings',
            'fragment_size' => 5,
            'number_of_fragments' => 5,
            'tags_schema' => 'styled',
            'post_tags' => ['</tag>', '</only_tag>'],
            'pre_tags' => ['<tag class="class">', '<only_tag>'],
            'fields' => [
                'name' => [
                    'matched_fields' => ['name'],
                ],
            ],
        ];
        $this->assertEquals($result, $highlight->toArray());
    }
}
