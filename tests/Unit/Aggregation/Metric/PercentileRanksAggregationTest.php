<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Metric\Aggregation;

use LogicException;
use ONGR\ElasticsearchDSL\Aggregation\Metric\PercentileRanksAggregation;

/**
 * Percentile ranks aggregation unit tests.
 */
class PercentileRanksAggregationTest extends \PHPUnit\Framework\TestCase
{
    public PercentileRanksAggregation $agg;

    public function setUp(): void
    {
        $this->agg = new PercentileRanksAggregation('foo');
    }

    public function testIfPercentileRanksAggregationThrowsAnException(): void
    {
        $this->expectException(LogicException::class);

        $this->agg->toArray();
    }

    public function testIfExceptionIsThrownWhenFieldSetAndValueNotSet(): void
    {
        $this->expectException(LogicException::class);

        $this->agg->setField('bar');
        $this->agg->toArray();
    }

    public function testIfExceptionIsThrownWhenScriptSetAndValueNotSet(): void
    {
        $this->expectException(LogicException::class);

        $this->agg->setScript('bar');
        $this->agg->toArray();
    }

    /**
     * Test getType method.
     */
    public function testGetType(): void
    {
        $this->assertEquals('percentile_ranks', $this->agg->getType());
    }

    /**
     * Test toArray method.
     */
    public function testToArray(): void
    {
        $this->agg->setField('bar');
        $this->agg->setValues(['bar']);
        $this->assertSame(
            [
                'percentile_ranks' => [
                    'field' => 'bar',
                    'values' => ['bar'],
                ],
            ],
            $this->agg->toArray()
        );
    }
}
