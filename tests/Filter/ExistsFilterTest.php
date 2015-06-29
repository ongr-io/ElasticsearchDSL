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

use ONGR\ElasticsearchDSL\Filter\ExistsFilter;

/**
 * Unit test for ExistsFilter.
 */
class ExistsFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests ExistsFilter#getType() method.
     */
    public function testGetType()
    {
        $filter = new ExistsFilter('bar');
        $this->assertEquals('exists', $filter->getType());
    }

    /**
     * Tests ExistsFilter#toArray() method.
     */
    public function testToArray()
    {
        $filter = new ExistsFilter('bar');
        $this->assertEquals(['field' => 'bar'], $filter->toArray());
    }
}
