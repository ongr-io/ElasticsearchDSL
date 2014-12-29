<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Filter;

use ONGR\ElasticsearchBundle\DSL\Filter\ExistsFilter;

class ExistsFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new ExistsFilter('foo', 'bar');
        $this->assertEquals('exists', $filter->getType());
    }

    /**
     * Test for filter toArray() method.
     */
    public function testToArray()
    {
        $filter = new ExistsFilter('foo', 'bar');
        $expectedResult = ['foo' => 'bar'];
        $this->assertEquals($expectedResult, $filter->toArray());
    }
}
