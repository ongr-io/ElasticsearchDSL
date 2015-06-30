<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Aggregation;

use ONGR\ElasticsearchDSL\Filter\BoolFilter;
use ONGR\ElasticsearchDSL\Filter\MissingFilter;
use ONGR\ElasticsearchDSL\Filter\TermFilter;

/**
 * Unit test for Bool.
 */
class BoolFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests isRelevant method.
     */
    public function testBoolIsRelevant()
    {
        $bool = new BoolFilter();
        $this->assertFalse($bool->isRelevant());
        $bool->add(new MissingFilter('test'));
        $this->assertTrue($bool->isRelevant());
    }

    /**
     * Test for addToBool() without setting a correct bool operator.
     *
     * @expectedException        \UnexpectedValueException
     * @expectedExceptionMessage The bool operator Should is not supported
     */
    public function testBoolAddToBoolException()
    {
        $bool = new BoolFilter();
        $bool->add(new MissingFilter('test'), 'Should');
    }

    /**
     * Tests toArray() method.
     */
    public function testBoolToArray()
    {
        $bool = new BoolFilter();
        $bool->add(new TermFilter('key1', 'value1'), 'should');
        $bool->add(new TermFilter('key2', 'value2'), 'must');
        $bool->add(new TermFilter('key3', 'value3'), 'must_not');
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
        $bool = new BoolFilter();
        $result = $bool->getType();
        $this->assertEquals('bool', $result);
    }
}
