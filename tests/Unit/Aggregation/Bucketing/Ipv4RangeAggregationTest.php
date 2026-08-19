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
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\Ipv4RangeAggregation;

class Ipv4RangeAggregationTest extends \PHPUnit\Framework\TestCase
{
    public function testIfExceptionIsThrownWhenFieldAndRangeAreNotSet()
    {
        $this->expectException(LogicException::class);

        $agg = new Ipv4RangeAggregation('foo');
        $agg->toArray();
    }

    public function testConstructorFilter(): void
    {
        $aggregation = new Ipv4RangeAggregation('test', 'fieldName', [['from' => 'fromValue']]);
        $this->assertSame(
            [
                'ip_range' => [
                    'field' => 'fieldName',
                    'ranges' => [['from' => 'fromValue']],
                ],
            ],
            $aggregation->toArray()
        );

        $aggregation = new Ipv4RangeAggregation('test', 'fieldName', ['maskValue']);
        $this->assertSame(
            [
                'ip_range' => [
                    'field' => 'fieldName',
                    'ranges' => [['mask' => 'maskValue']],
                ],
            ],
            $aggregation->toArray()
        );
    }
}
