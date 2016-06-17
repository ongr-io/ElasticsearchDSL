<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\SamplerAggregation;

/**
 * Unit test for children aggregation.
 */
class SamplerAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests getType method.
     */
    public function testSamplerAggregationGetType()
    {
        $aggregation = new SamplerAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('sampler', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testSamplerAggregationGetArray()
    {
        $mock = $this->getMockBuilder('ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $aggregation = new SamplerAggregation('foo');
        $aggregation->addAggregation($mock);
        $aggregation->setField('name');
        $aggregation->setShardSize(200);
        $result = $aggregation->getArray();
        $expected = ['field' => 'name', 'shard_size' => 200];
        $this->assertEquals($expected, $result);
    }
}
