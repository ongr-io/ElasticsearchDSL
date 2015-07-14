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

use ONGR\ElasticsearchDSL\Suggester\Suggester;

/**
 * Class SuggesterTest.
 */
class SuggesterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for testGettersSetters.
     *
     * @return array
     */
    public function gettersSettersProvider()
    {
        $context = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\Suggester\ContextInterface');

        return [
            ['type', 'string1'],
            ['field', 'string2'],
            ['text', 'string3'],
            ['name', 'string4', '-'],
            ['context', $context, [], true],
        ];
    }

    /**
     * Tests property accessors.
     *
     * @param string $property
     * @param mixed  $value
     * @param mixed  $default
     * @param bool   $adders
     *
     * @dataProvider gettersSettersProvider
     */
    public function testGettersSetters($property, $value, $default = null, $adders = false)
    {
        /** @var Suggester $suggester */
        $suggester = $this->getMockBuilder('ONGR\ElasticsearchDSL\Suggester\Suggester')->disableOriginalConstructor()
            ->setMethods(null)->getMock();

        $single = $value;
        if ($adders) {
            $value = [$value];
        }

        $this->assertSame($default, $suggester->{'get' . ucfirst($property)}());
        $this->assertSame($suggester, $suggester->{'set' . ucfirst($property)}($value));
        $this->assertSame($value, $suggester->{'get' . ucfirst($property)}());

        if (!$adders) {
            return;
        }

        $suggester->{'set' . ucfirst($property)}([]);
        $suggester->{'add' . ucfirst($property)}($single);
        $this->assertSame($value, $suggester->{'get' . ucfirst($property)}());
    }

    /**
     * Tests default naming.
     */
    public function testDefaultName()
    {
        $suggester = new Suggester(Suggester::TYPE_TERM, 'fieldString', 'text');
        $this->assertSame('fieldString-' . Suggester::TYPE_TERM, $suggester->getName());
    }

    /**
     * Data provider for testToArray.
     *
     * @return array
     */
    public function toArrayProvider()
    {
        $context = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\Suggester\ContextInterface');
        $context->expects($this->any())->method('toArray')->willReturn(['contextField' => 'data']);
        $context->expects($this->any())->method('getName')->willReturn('contextName');

        return [
            // Case #0. Phrase type.
            [
                'type' => Suggester::TYPE_PHRASE,
                'field' => 'fieldName',
                'text' => 'TextString',
                'parameters' => ['parameterName' => 'parameterValue'],
                'name' => null,
                'expected' => [
                    'fieldName-phrase' => [
                        'text' => 'TextString',
                        'phrase' => [
                            'field' => 'fieldName',
                            'parameterName' => 'parameterValue',
                        ],
                    ],
                ],
            ],
            // Case #1. Term type.
            [
                'type' => Suggester::TYPE_TERM,
                'field' => 'fieldName',
                'text' => 'TextString',
                'parameters' => ['parameterName' => 'parameterValue'],
                'name' => null,
                'expected' => [
                    'fieldName-term' => [
                        'text' => 'TextString',
                        'term' => [
                            'field' => 'fieldName',
                            'parameterName' => 'parameterValue',
                        ],
                    ],
                ],
            ],
            // Case #2. Completion type.
            [
                'type' => Suggester::TYPE_COMPLETION,
                'field' => 'fieldName',
                'text' => 'TextString',
                'parameters' => ['parameterName' => 'parameterValue'],
                'name' => null,
                'expected' => [
                    'fieldName-completion' => [
                        'text' => 'TextString',
                        'completion' => [
                            'field' => 'fieldName',
                            'parameterName' => 'parameterValue',
                        ],
                    ],
                ],
            ],
            // Case #3. Context type.
            [
                'type' => Suggester::TYPE_CONTEXT,
                'field' => 'fieldName',
                'text' => 'TextString',
                'parameters' => ['parameterName' => 'parameterValue'],
                'name' => null,
                'expected' => [
                    'fieldName-completion' => [
                        'text' => 'TextString',
                        'completion' => [
                            'field' => 'fieldName',
                            'context' => [
                                'contextName' => [
                                    'contextField' => 'data',
                                ],
                            ],
                            'parameterName' => 'parameterValue',
                        ],
                    ],
                ],
                'context' => [$context],
            ],
        ];
    }

    /**
     * Tests toArray method.
     *
     * @dataProvider toArrayProvider
     *
     * @param string $type
     * @param string $field
     * @param string $text
     * @param array  $parameters
     * @param string $name
     * @param array  $expected
     * @param array  $context
     */
    public function testToArray($type, $field, $text, $parameters, $name, $expected, $context = null)
    {
        $suggester = new Suggester($type, $field, $text, $parameters, $name);
        if ($context !== null) {
            $suggester->setContext($context);
        }
        $this->assertSame($expected, $suggester->toArray());
    }
}
