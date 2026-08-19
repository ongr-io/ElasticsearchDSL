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
use ONGR\ElasticsearchDSL\Aggregation\Metric\PercentilesAggregation;

class PercentilesAggregationTest extends \PHPUnit\Framework\TestCase
{
    public function testPercentilesAggregationGetArrayException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Percentiles aggregation must have field or script set.');

        $aggregation = new PercentilesAggregation('bar');
        $aggregation->getArray();
    }

    public function testGetType(): void
    {
        $aggregation = new PercentilesAggregation('bar');
        $this->assertEquals('percentiles', $aggregation->getType());
    }

    public function testGetArray(): void
    {
        $aggregation = new PercentilesAggregation('bar', 'fieldValue', ['percentsValue']);
        $this->assertSame(
            [
                'percents' => ['percentsValue'],
                'field' => 'fieldValue',
            ],
            $aggregation->getArray()
        );
    }
}
