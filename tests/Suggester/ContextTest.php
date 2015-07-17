<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Suggester;

use ONGR\ElasticsearchDSL\Suggester\Context;

/**
 * Class ContextTest.
 */
class ContextTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for testGettersSetters.
     *
     * @return array
     */
    public function gettersSettersProvider()
    {
        return [
            ['name', 'string1'],
            ['value', 'string2'],
            ['type', 'string3'],
        ];
    }

    /**
     * Tests property accessors.
     *
     * @param string $property
     * @param mixed  $value
     * @param mixed  $default
     *
     * @dataProvider gettersSettersProvider
     */
    public function testGettersSetters($property, $value, $default = null)
    {
        /** @var Context $suggester */
        $context = $this->getMockBuilder('ONGR\ElasticsearchDSL\Suggester\Context')->disableOriginalConstructor()
            ->setMethods(null)->getMock();

        $this->assertSame($default, $context->{'get' . ucfirst($property)}());
        $this->assertSame($context, $context->{'set' . ucfirst($property)}($value));
        $this->assertSame($value, $context->{'get' . ucfirst($property)}());
    }

    /**
     * Data provider for testToArray.
     *
     * @return array
     */
    public function toArrayProvider()
    {
        return [
            // Case #0. Category context.
            [
                'name' => 'contextName',
                'value' => 'contextValue',
                'type' => Context::TYPE_CATEGORY,
                'expected' => 'contextValue',
            ],
            // Case #1. Geo location context.
            [
                'name' => 'contextName',
                'value' => 'contextValue',
                'type' => Context::TYPE_GEO_LOCATION,
                'expected' => [
                    'value' => 'contextValue',
                ],
            ],
            // Case #2. Geo location context parameters.
            [
                'name' => 'contextName',
                'value' => 'contextValue',
                'type' => Context::TYPE_GEO_LOCATION,
                'expected' => [
                    'value' => 'contextValue',
                    'precision' => '1km',
                ],
                'parameters' => ['precision' => '1km'],
            ],
        ];
    }

    /**
     * Tests toArray method.
     *
     * @dataProvider toArrayProvider
     *
     * @param string $name
     * @param mixed  $value
     * @param string $type
     * @param array  $expected
     * @param array  $parameters
     */
    public function testToArray($name, $value, $type, $expected, $parameters = [])
    {
        $context = new Context($name, $value, $type, $parameters);
        $this->assertSame($expected, $context->toArray());
    }
}
