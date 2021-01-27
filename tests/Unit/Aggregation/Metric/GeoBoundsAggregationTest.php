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
use ONGR\ElasticsearchDSL\Aggregation\Metric\GeoBoundsAggregation;

/**
 * Unit test for geo bounds aggregation.
 */
class GeoBoundsAggregationTest extends \PHPUnit\Framework\TestCase
{
    public function testGeoBoundsAggregationException(): void
    {
        $this->expectException(LogicException::class);

        $agg = new GeoBoundsAggregation('test_agg');
        $agg->getArray();
    }

    public function testGeoBoundsAggregationGetType(): void
    {
        $agg = new GeoBoundsAggregation('foo');
        $result = $agg->getType();
        $this->assertEquals('geo_bounds', $result);
    }

    public function testGeoBoundsAggregationGetArray(): void
    {
        $agg = new GeoBoundsAggregation('foo');
        $agg->setField('bar');
        $agg->setWrapLongitude(true);
        $result = [
            'geo_bounds' => [
                'field' => 'bar',
                'wrap_longitude' => true,
            ],
        ];
        $this->assertEquals($result, $agg->toArray(), 'when wraplongitude is true');

        $agg->setWrapLongitude(false);
        $result = [
            'geo_bounds' => [
                'field' => 'bar',
                'wrap_longitude' => false,
            ],
        ];
        $this->assertEquals($result, $agg->toArray(), 'when wraplongitude is false');
    }
}
