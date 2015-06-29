<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Filter;

use ONGR\ElasticsearchDSL\Filter\IdsFilter;

class IdsFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new IdsFilter([], []);
        $result = $filter->getType();
        $this->assertEquals('ids', $result);
    }

    /**
     * Data provider to testGetToArray.
     *
     * @return array
     */
    public function getArrayDataProvider()
    {
        return [
            // Case #1.
            [['acme', 'bar'], ['type' => 'acme'], ['values' => ['acme', 'bar'], 'type' => 'acme']],
            // Case #2.
            [[], [], ['values' => []]],
            // Case #3.
            [['acme'], [], ['values' => ['acme']]],
        ];
    }

    /**
     * Test for filter toArray() method.
     *
     * @param string[] $values     Ids' values.
     * @param array    $parameters Optional parameters.
     * @param array    $expected   Expected result.
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray($values, $parameters, $expected)
    {
        $filter = new IdsFilter($values, $parameters);
        $result = $filter->toArray();
        $this->assertEquals($expected, $result);
    }
}
