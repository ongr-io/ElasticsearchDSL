<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Query;

use ONGR\ElasticsearchDSL\Query\FilteredQuery;
use ONGR\ElasticsearchDSL\Query\IndicesQuery;
use ONGR\ElasticsearchDSL\Test\EncapsulationTestAwareTrait;

class IndicesQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for testToArrayManyIndices function.
     *
     * @return array
     */
    public function getArrayWithManyIndicesDataProvider()
    {
        $queryMock = $this->getMockBuilder('ONGR\ElasticsearchDSL\Query\Query')
            ->getMock();
        $queryMock->expects($this->any())
            ->method('toArray')
            ->willReturn(['testKey' => 'testValue']);
        $queryMock->expects($this->any())
            ->method('getType')
            ->willReturn('testType');

        return [
            [
                $queryMock,
                [
                    'test_indice1',
                    'test_indice2',
                ],
                [
                    'indices' => [
                        'test_indice1',
                        'test_indice2',
                    ],
                    'query' => [
                        'testType' => [
                            'testKey' => 'testValue',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Test toArray() method when the number of indices > 1.
     *
     * @param Query $query      Query for testing.
     * @param array $parameters Optional parameters.
     * @param array $expected   Expected values.
     *
     * @dataProvider getArrayWithManyIndicesDataProvider
     */
    public function testToArrayWithManyIndices($query, $parameters, $expected)
    {
        $query = new IndicesQuery($parameters, $query);
        $this->assertEquals($expected, $query->toArray());
    }
}
