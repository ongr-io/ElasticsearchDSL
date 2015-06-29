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

use ONGR\ElasticsearchDSL\Filter\ScriptFilter;

class ScriptFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new ScriptFilter('');
        $this->assertEquals('script', $filter->getType());
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
            ['', [], ['script' => '']],
            // Case #2.
            ['foo', [], ['script' => 'foo']],
            // Case #3.
            ['foo', ['type' => 'acme'], ['script' => 'foo', 'type' => 'acme']],
        ];
    }

    /**
     * Test for filter toArray() method.
     *
     * @param string $script     Script.
     * @param array  $parameters Optional parameters.
     * @param array  $expected   Expected values.
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray($script, $parameters, $expected)
    {
        $filter = new ScriptFilter($script, $parameters);
        $result = $filter->toArray();
        $this->assertEquals($expected, $result);
    }
}
