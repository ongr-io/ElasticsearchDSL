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

use ONGR\ElasticsearchBundle\DSL\Filter\HasChildFilter;

class HasChildFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $mock = $this->getMockBuilder('ONGR\ElasticsearchBundle\DSL\BuilderInterface')->getMock();
        $filter = new HasChildFilter('test_field', $mock);
        $result = $filter->getType();
        $this->assertEquals('has_child', $result);
    }
}
