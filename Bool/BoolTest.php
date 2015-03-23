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
use ONGR\ElasticsearchBundle\DSL\Filter\TermFilter;

/**
 * Unit test for Bool.
 */
class BoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests isRelevant method.
     */
    public function testBoolIsRelevant()
    {
        $bool = new Bool();
        $this->assertEquals(false, $bool->isRelevant());
        $bool->addToBool(new MissingFilter('test'));
        $this->assertEquals(true, $bool->isRelevant());
    }

    /**
     * Test for addToBool() without setting a correct bool operator.
     *
     * @expectedException        \UnexpectedValueException
     * @expectedExceptionMessage The bool operator Should is not supported
     */
    public function testBoolAddToBoolException()
    {
        $bool = new Bool();
        $bool->addToBool(new MissingFilter('test'), 'Should');
    }

    /**
     * Tests toArray() method.
     */
    public function testBoolToArray()
    {
        $bool = new Bool();
        $bool->addToBool(new TermFilter('key1', 'value1'), 'should');
        $bool->addToBool(new TermFilter('key2', 'value2'), 'must');
        $bool->addToBool(new TermFilter('key3', 'value3'), 'must_not');
        $expected = [
            'should' => [
                [
                    'term' => [
                        'key1' => 'value1',
                    ],
                ],
            ],
            'must' => [
                [
                    'term' => [
                        'key2' => 'value2',
                    ],
                ],
            ],
            'must_not' => [
                [
                    'term' => [
                        'key3' => 'value3',
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $bool->toArray());
    }

    /**
     * Test getType method.
     */
    public function testBoolGetType()
    {
        $bool = new Bool();
        $result = $bool->getType();
        $this->assertEquals('bool', $result);
    }
}
