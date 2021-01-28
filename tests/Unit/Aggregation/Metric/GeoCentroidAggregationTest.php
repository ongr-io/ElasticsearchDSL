<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Tests\Unit\Metric\Aggregation;

use LogicException;
use ONGR\ElasticsearchDSL\Aggregation\Metric\GeoCentroidAggregation;

/**
 * Unit test for children aggregation.
 */
class GeoCentroidAggregationTest extends \PHPUnit\Framework\TestCase
{
    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);

        $aggregation = new GeoCentroidAggregation('foo');
        $aggregation->getArray();
    }

    public function testGeoCentroidAggregationGetType(): void
    {
        $aggregation = new GeoCentroidAggregation('foo');
        $this->assertEquals('geo_centroid', $aggregation->getType());
    }

    public function testGeoCentroidAggregationGetArray(): void
    {
        $aggregation = new GeoCentroidAggregation('foo', 'location');
        $this->assertEquals(['field' => 'location'], $aggregation->getArray());
    }
}
