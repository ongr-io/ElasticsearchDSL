<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\MissingAggregation;

class MissingAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test if exception is thrown when field is not set.
     */
    public function testIfExceptionIsThrown()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Missing aggregation must have a field set.');
        $agg = new MissingAggregation('test_agg');
        $agg->getArray();
    }

    /**
     * Test getArray method.
     */
    public function testMissingAggregationGetArray()
    {
        $aggregation = new MissingAggregation('foo');
        $aggregation->setField('bar');
        $result = $aggregation->getArray();
        $this->assertEquals('bar', $result['field']);
    }

    /**
     * Test getType method.
     */
    public function testMissingAggregationGetType()
    {
        $aggregation = new MissingAggregation('bar');
        $result = $aggregation->getType();
        $this->assertEquals('missing', $result);
    }
}
