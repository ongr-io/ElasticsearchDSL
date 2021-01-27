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
use ONGR\ElasticsearchDSL\Aggregation\Pipeline\BucketScriptAggregation;

/**
 * Unit test for bucket script pipeline aggregation.
 */
class BucketScriptAggregationTest extends \PHPUnit\Framework\TestCase
{
    public function testToArray(): void
    {
        $aggregation = new BucketScriptAggregation(
            'test',
            [
                'my_var1' => 'foo',
                'my_var2' => 'bar',
            ]
        );
        $aggregation->setScript('test script');
        $aggregation->addParameter('gap_policy', 'insert_zeros');

        $expected = [
            'bucket_script' => [
                'buckets_path' => [
                    'my_var1' => 'foo',
                    'my_var2' => 'bar',
                ],
                'script' => 'test script',
                'gap_policy' => 'insert_zeros',
            ],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }

    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage("`test` aggregation must have script set.");

        $agg = new BucketScriptAggregation('test', []);

        $agg->getArray();
    }
}
