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

use ONGR\ElasticsearchBundle\DSL\Filter\TermFilter;
use ONGR\ElasticsearchBundle\DSL\Highlight\Field;

/**
 * Unit test for Field.
 */
class FieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests getType method.
     */
    public function testGetType()
    {
        $field = new Field('test');

        $field->setHighlighterType(Field::TYPE_FVH);
        $this->assertEquals(Field::TYPE_FVH, $field->getType());

        $field->setHighlighterType(Field::TYPE_PLAIN);
        $this->assertEquals(Field::TYPE_PLAIN, $field->getType());

        $field->setHighlighterType(Field::TYPE_POSTINGS);
        $this->assertEquals(Field::TYPE_POSTINGS, $field->getType());

        $initValue = $field->getType();

        $field->setHighlighterType('wrongValue');
        $this->assertEquals($initValue, $field->getType());
    }

    /**
     * Tests toArray method.
     */
    public function testFieldToArray()
    {
        $field = new Field('test');
        $field->setFragmentSize(5);
        $field->setNumberOfFragments(5);
        $field->setHighlightQuery(new TermFilter('key1', 'value1'));
        $field->setNoMatchSize(3);
        $field->setForceSource(true);

        $result = [
            'fragment_size' => 5,
            'number_of_fragments' => 5,
            'matched_fields' => ['test'],
            'highlight_query' => [
                'term' => [
                    'key1' => 'value1',
                ],
            ],
            'no_match_size' => 3,
            'force_source' => true,
        ];
        $this->assertEquals($result, $field->toArray());
    }

    /**
     * Tests getName method.
     */
    public function testFieldGetName()
    {
        $field = new Field('test');
        $result = $field->getName();
        $this->assertEquals('test', $result);
    }
}
