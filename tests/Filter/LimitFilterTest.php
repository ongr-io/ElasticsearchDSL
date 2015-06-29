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

use ONGR\ElasticsearchDSL\Filter\LimitFilter;

class LimitFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new LimitFilter(0);
        $this->assertEquals('limit', $filter->getType());
    }

    /**
     * Test for filter toArray() method.
     */
    public function testToArray()
    {
        $filter = new LimitFilter(0);
        $expectedResult = ['value' => 0];
        $this->assertEquals($expectedResult, $filter->toArray());
    }
}
