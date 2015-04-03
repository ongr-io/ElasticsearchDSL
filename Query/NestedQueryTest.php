<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Query;

use ONGR\ElasticsearchBundle\DSL\Query\NestedQuery;

class NestedQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests toArray method.
     */
    public function testToArray()
    {
        $missingFilterMock = $this->getMockBuilder('ONGR\ElasticsearchBundle\DSL\Filter\MissingFilter')
            ->setConstructorArgs(['test_field'])
            ->getMock();
        $missingFilterMock->expects($this->any())
            ->method('getType')
            ->willReturn('test_type');
        $missingFilterMock->expects($this->any())
            ->method('toArray')
            ->willReturn(['testKey' => 'testValue']);

        $result = [
            'path' => 'test_path',
            'query' => [
                'test_type' => ['testKey' => 'testValue'],
            ],
        ];

        $query = new NestedQuery('test_path', $missingFilterMock);
        $this->assertEquals($result, $query->toArray());
    }
}
