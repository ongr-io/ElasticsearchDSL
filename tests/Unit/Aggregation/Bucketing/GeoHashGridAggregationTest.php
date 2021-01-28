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

namespace ONGR\ElasticsearchDSL\Tests\Unit\Bucketing\Aggregation;

use LogicException;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\GeoHashGridAggregation;

class GeoHashGridAggregationTest extends \PHPUnit\Framework\TestCase
{
    public function testGeoHashGridAggregationException()
    {
        $this->expectException(LogicException::class);

        $agg = new GeoHashGridAggregation('test_agg');
        $agg->getArray();
    }

    public function getArrayDataProvider(): array
    {
        $out = [];

        $filterData = [
            'field' => 'location',
            'precision' => 3,
            'size' => 10,
            'shard_size' => 10,
        ];

        $expectedResults = [
            'field' => 'location',
            'precision' => 3,
            'size' => 10,
            'shard_size' => 10,
        ];

        $out[] = [$filterData, $expectedResults];

        return $out;
    }

    /**
     * Tests getArray method.
     *
     * @param array $filterData
     * @param array $expected
     *
     * @dataProvider getArrayDataProvider
     */
    public function testGeoHashGridAggregationGetArray($filterData, $expected): void
    {
        $aggregation = new GeoHashGridAggregation('foo');
        $aggregation->setPrecision($filterData['precision']);
        $aggregation->setSize($filterData['size']);
        $aggregation->setShardSize($filterData['shard_size']);
        $aggregation->setField($filterData['field']);

        $result = $aggregation->getArray();
        $this->assertEquals($result, $expected);
    }

    public function testGeoHashGridAggregationGetType(): void
    {
        $aggregation = new GeoHashGridAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('geohash_grid', $result);
    }
}
