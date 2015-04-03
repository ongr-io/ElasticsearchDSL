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
            ->setMethods(['addToBool'])
            ->disableOriginalConstructor()
            ->getMock();
        $missingFilterMock->expects($this->once())
            ->method('addToBool')
            ->withAnyParameters();

        $postFilter = new PostFilter();
        $postFilter->setFilter($missingFilterMock);
        $postFilter->addFilter($missingFilterMock, 'test');
    }

    /**
     * Test setBoolParameters method.
     */
    public function testSetBoolParameters()
    {
        $missingFilterMock = $this->getMockBuilder('ONGR\ElasticsearchBundle\DSL\Filter\MissingFilter')
            ->setMethods(['setParameters'])
            ->disableOriginalConstructor()
            ->getMock();
        $missingFilterMock->expects($this->once())
            ->method('setParameters')
            ->withAnyParameters();

        $postFilter = new PostFilter();
        $postFilter->setFilter($missingFilterMock);
        $postFilter->setBoolParameters(['test_param']);
    }
}
