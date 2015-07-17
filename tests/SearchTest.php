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

use ONGR\ElasticsearchDSL\NamedBuilderInterface;
use ONGR\ElasticsearchDSL\Search;

/**
 * Test for Search.
 */
class SearchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Search constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf('ONGR\ElasticsearchDSL\Search', new Search());
    }

    /**
     * Tests if suggestions are formatted correctly.
     */
    public function testSuggestionEndpoint()
    {
        $search = new Search();
        /** @var NamedBuilderInterface|\PHPUnit_Framework_MockObject_MockObject $suggester */
        $suggester = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\NamedBuilderInterface');
        $suggester->expects($this->any())->method('getName')->willReturn('fieldName-completion');
        $suggester->expects($this->any())->method('getType')->willReturn('completion');
        $suggester->expects($this->any())->method('toArray')->willReturn(
            [
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
            ]
        );
        /** @var NamedBuilderInterface|\PHPUnit_Framework_MockObject_MockObject $suggester2 */
        $suggester2 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\NamedBuilderInterface');
        $suggester2->expects($this->any())->method('getName')->willReturn('fieldName-phrase');
        $suggester2->expects($this->any())->method('getType')->willReturn('phrase');
        $suggester2->expects($this->any())->method('toArray')->willReturn(
            [
                'fieldName-phrase' => [
                    'text' => 'TextString',
                    'phrase' => [
                        'field' => 'fieldName',
                        'parameterName' => 'parameterValue',
                    ],
                ],
            ]
        );
        $search->addSuggestion($suggester);
        $search->addSuggestion($suggester2);

        $this->assertSame(
            ['fieldName-completion' => $suggester, 'fieldName-phrase' => $suggester2],
            $search->getSuggestions()
        );

        $this->assertSame(
            [
                'suggest' => [
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
                    'fieldName-phrase' => [
                        'text' => 'TextString',
                        'phrase' => [
                            'field' => 'fieldName',
                            'parameterName' => 'parameterValue',
                        ],
                    ],
                ],
            ],
            $search->toArray()
        );
    }
}
