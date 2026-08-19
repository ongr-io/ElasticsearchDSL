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

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use LogicException;
use ONGR\ElasticsearchDSL\Aggregation\Pipeline\BucketSelectorAggregation;

/**
 * Unit test for bucket selector pipeline aggregation.
 */
class BucketSelectorAggregationTest extends \PHPUnit\Framework\TestCase
{
    public function testToArray(): void
    {
        $aggregation = new BucketSelectorAggregation(
            'test',
            [
                'my_var1' => 'foo',
                'my_var2' => 'bar',
            ]
        );
        $aggregation->setScript('foo > bar');

        $expected = [
            'bucket_selector' => [
                'buckets_path' => [
                    'my_var1' => 'foo',
                    'my_var2' => 'bar',
                ],
                'script' => 'foo > bar',
            ],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }

    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("`test` aggregation must have script set.");

        $agg = new BucketSelectorAggregation('test', []);

        $agg->getArray();
    }
}
