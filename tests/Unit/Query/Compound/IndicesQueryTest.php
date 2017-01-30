<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Compound;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Query\Compound\IndicesQuery;

class IndicesQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|BuilderInterface
     */
    private function getQueryMock()
    {
        $mock = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')
            ->setMethods(['toArray', 'getType'])->getMock();
        $mock
            ->expects($this->any())
            ->method('toArray')
            ->willReturn(['term' => ['foo' => 'bar']]);
        return $mock;
    }
    /**
     * Data provider for testToArray().
     *
     * @return array
     */
    public function getTestToArrayData()
    {
        return [
            [
                $this->getQueryMock(),
                'all',
                [
                    'indices' => ['foo', 'bar'],
                    'query' => ['term' => ['foo' => 'bar']],
                    'no_match_query' => 'all',
                ]
            ],
            [
                $this->getQueryMock(),
                $this->getQueryMock(),
                [
                    'indices' => ['foo', 'bar'],
                    'query' => ['term' => ['foo' => 'bar']],
                    'no_match_query' => ['term' => ['foo' => 'bar']],
                ]
            ],
            [
                $this->getQueryMock(),
                null,
                [
                    'indices' => ['foo', 'bar'],
                    'query' => ['term' => ['foo' => 'bar']],
                ]
            ],
        ];
    }

    /**
     * Tests toArray().
     *
     * @param $query
     * @param $noMatchQuery
     * @param $expected
     *
     * @dataProvider getTestToArrayData()
     */
    public function testToArray($query, $noMatchQuery, $expected)
    {
        $query = new IndicesQuery(['foo', 'bar'], $query, $noMatchQuery);
        $this->assertEquals(['indices' => $expected], $query->toArray());
    }
}
