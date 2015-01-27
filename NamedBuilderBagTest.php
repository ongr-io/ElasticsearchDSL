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


use ONGR\ElasticsearchBundle\DSL\NamedBuilderBag;
use ONGR\ElasticsearchBundle\DSL\NamedBuilderInterface;

class NamedBuilderBagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests if bag knows if he has a builder.
     */
    public function testHas()
    {
        $bag = new NamedBuilderBag(
            [
                $this->getBuilder('foo'),
            ]
        );
        $this->assertTrue($bag->has('foo'));
    }

    /**
     * Tests if bag can remove a builder.
     */
    public function testRemove()
    {
        $bag = new NamedBuilderBag(
            [
                $this->getBuilder('foo'),
                $this->getBuilder('baz'),
            ]
        );

        $bag->remove('foo');

        $this->assertFalse($bag->has('foo'), 'Foo builder should not exist anymore.');
        $this->assertTrue($bag->has('baz'), 'Baz builder should exist.');
    }

    /**
     * Tests if bag can clear it's builders.
     */
    public function testClear()
    {
        $bag = new NamedBuilderBag(
            [
                $this->getBuilder('foo'),
                $this->getBuilder('baz'),
            ]
        );

        $bag->clear();

        $this->assertEmpty($bag->all());
    }

    /**
     * Tests if bag can get a builder.
     */
    public function testGet()
    {
        $bag = new NamedBuilderBag(
            [
                $this->getBuilder('baz'),
            ]
        );

        $this->assertNotEmpty($bag->get('baz'));
    }

    /**
     * Returns builder.
     *
     * @param string $name
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|NamedBuilderInterface
     */
    private function getBuilder($name)
    {
        $friendlyBuilderMock = $this->getMock('ONGR\ElasticsearchBundle\DSL\NamedBuilderInterface');

        $friendlyBuilderMock
            ->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($name));

        $friendlyBuilderMock
            ->expects($this->any())
            ->method('toArray')
            ->will($this->returnValue([]));

        return $friendlyBuilderMock;
    }
}
