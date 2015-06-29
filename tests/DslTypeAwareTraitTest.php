<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL;

use ONGR\ElasticsearchDSL\DslTypeAwareTrait;

/**
 * Test for DslTypeAwareTrait.
 */
class DslTypeAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DslTypeAwareTrait
     */
    private $mock;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->mock = $this->getMockForTrait('ONGR\ElasticsearchDSL\DslTypeAwareTrait');
    }

    /**
     * Tests if setDslType throws exception.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testIfSetDslTypeExceptionThrowsException()
    {
        $this->mock->setDslType('foo');
    }

    /**
     * Tests if setDslType sets filter.
     */
    public function testIfSetDslTypeSetsFilter()
    {
        $this->mock->setDslType('filter');
        $this->assertEquals('filter', $this->mock->getDslType());
    }

    /**
     * Tests if setDslType sets query.
     */
    public function testIfSetDslTypeSetsQuery()
    {
        $this->mock->setDslType('query');
        $this->assertEquals('query', $this->mock->getDslType());
    }
}
