<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\Metric\CardinalityAggregation;

/**
 * Unit test for cardinality aggregation.
 */
class CardinalityAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests getArray method.
     */
    public function testGetArray()
    {
        $aggregation = new CardinalityAggregation('bar');

        $aggregation->setScript('foo');
        $result = $aggregation->getArray();

        $this->assertArrayHasKey('script', $result, 'key=script when script is set');
        $this->assertEquals('foo', $result['script'], 'script=foo when scripts name=foo');

        $aggregation->setField('foo');
        $result = $aggregation->getArray();

        $this->assertArrayHasKey('field', $result, 'key=field when field is set');
        $this->assertEquals('foo', $result['field'], 'field=foo when fields name=foo');

        $aggregation->setPrecisionThreshold(10);
        $result = $aggregation->getArray();

        $this->assertArrayHasKey('precision_threshold', $result, 'key=precision_threshold when is set');
        $this->assertEquals(10, $result['precision_threshold'], 'precision_threshold=10 when is set');

        $aggregation->setRehash(true);
        $result = $aggregation->getArray();

        $this->assertArrayHasKey('rehash', $result, 'key=rehash when rehash is set');
        $this->assertEquals(true, $result['rehash'], 'rehash=true when rehash is set to true');
    }

    /**
     * Tests if CardinalityAggregation#getArray throws exception when expected.
     */
    public function testGetArrayException()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Cardinality aggregation must have field or script set.');
        $aggregation = new CardinalityAggregation('bar');
        $aggregation->getArray();
    }

    /**
     * Tests getType method.
     */
    public function testCardinallyAggregationGetType()
    {
        $aggregation = new CardinalityAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('cardinality', $result);
    }
}
