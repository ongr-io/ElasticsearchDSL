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

use ONGR\ElasticsearchBundle\DSL\Filter\PostFilter;

class PostFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testIfGetType()
    {
        $postFilter = new PostFilter();
        $this->assertEquals('post_filter', $postFilter->getType());
    }

    /**
     * Test if function is returning False.
     */
    public function testIfIsRelevantFunctionIsReturningFalse()
    {
        $postFilter = new PostFilter();
        $this->assertFalse($postFilter->isRelevant());
    }

    /**
     * Test addFilter method.
     */
    public function testAddFilter()
    {
        $missingFilterMock = $this->getMockBuilder('ONGR\ElasticsearchBundle\DSL\Filter\MissingFilter')
            ->disableOriginalConstructor()
            ->getMock();
        $missingFilterMock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn([]);
        $missingFilterMock
            ->expects($this->once())
            ->method('getType')
            ->willReturn('test_type');

        $postFilter = new PostFilter();
        $postFilter->setFilter($missingFilterMock);
        $this->assertEquals(['test_type' => []], $postFilter->toArray());
    }
}
