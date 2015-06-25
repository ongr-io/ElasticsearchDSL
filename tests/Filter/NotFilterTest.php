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

use ONGR\ElasticsearchBundle\DSL\Filter\NotFilter;

class NotFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests GetType method.
     */
    public function testGetType()
    {
        $filter = new NotFilter();
        $this->assertEquals('not', $filter->getType());
    }

    /**
     * Data provider for testToArray function.
     *
     * @return array
     */
    public function getArrayDataProvider()
    {
        $mockBuilder = $this->getMockBuilder('ONGR\ElasticsearchBundle\DSL\BuilderInterface')
            ->getMock();
        $mockBuilder->expects($this->any())
            ->method('getType')
            ->willReturn('range');
        $mockBuilder->expects($this->any())
            ->method('toArray')
            ->willReturn(['postDate' => ['from' => '2010-03-01', 'to' => '2010-04-01']]);

        return [
            // Case #1.
            [
                $mockBuilder,
                [],
                [
                    'filter' => [
                        'range' => [
                            'postDate' => [
                                'from' => '2010-03-01',
                                'to' => '2010-04-01',
                            ],
                        ],
                    ],
                ],
            ],
            // Case #2.
            [
                $mockBuilder,
                [
                    'type' => 'acme',
                ],
                [
                    'filter' => [
                        'range' => [
                            'postDate' => [
                                'from' => '2010-03-01',
                                'to' => '2010-04-01',
                            ],
                        ],
                    ],
                    'type' => 'acme',
                ],
            ],
        ];
    }

    /**
     * Test for filter toArray() method.
     *
     * @param BuilderInterface $filter     Filter.
     * @param array            $parameters Optional parameters.
     * @param array            $expected   Expected values.
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArrayMethod($filter, $parameters, $expected)
    {
        $filter = new NotFilter($filter, $parameters);
        $result = $filter->toArray();
        $this->assertEquals($expected, $filter->toArray());
    }
}
