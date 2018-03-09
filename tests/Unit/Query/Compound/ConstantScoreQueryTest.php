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

use ONGR\ElasticsearchDSL\Query\Compound\ConstantScoreQuery;

class ConstantScoreQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray()
    {
        $mock = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')->getMock();
        $mock
            ->expects($this->any())
            ->method('toArray')
            ->willReturn(['term' => ['foo' => 'bar']]);

        $query = new ConstantScoreQuery($mock, ['boost' => 1.2]);
        $expected = [
            'constant_score' => [
                'filter' => [
                    'term' => ['foo' => 'bar']
                ],
                'boost' => 1.2,
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
