<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL;

/**
 * Tests query aware trait provided methods.
 */
class QueryAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests hasQuery method without any queries loaded.
     */
    public function testHasQueryMethodWithoutQueries()
    {
        $mock = $this->getMockForTrait('ONGR\ElasticsearchBundle\DSL\Query\QueryAwareTrait');
        $this->assertFalse($mock->hasQuery('some_type'));
    }

    /**
     * Tests hasQuery method with one query loaded.
     */
    public function testHasQueryMethodWithQueries()
    {
        $builder = $this->getMock('ONGR\ElasticsearchBundle\DSL\BuilderInterface');
        $builder->expects($this->once())->method('getType')->willReturn('foo_type');
        $mock = $this->getMockForTrait('ONGR\ElasticsearchBundle\DSL\Query\QueryAwareTrait');
        $mock->addQuery($builder);
        $this->assertTrue($mock->hasQuery('foo_type'));
    }
}
