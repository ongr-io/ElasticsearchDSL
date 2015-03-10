<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Aggregation;

use ONGR\ElasticsearchBundle\DSL\Bool\Bool;
use ONGR\ElasticsearchBundle\DSL\Filter\MissingFilter;
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
}
