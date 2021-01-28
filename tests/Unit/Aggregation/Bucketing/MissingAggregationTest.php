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
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\MissingAggregation;

class MissingAggregationTest extends \PHPUnit\Framework\TestCase
{
    public function testIfExceptionIsThrown(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Missing aggregation must have a field set.');

        $agg = new MissingAggregation('test_agg');
        $agg->getArray();
    }

    public function testMissingAggregationGetArray(): void
    {
        $aggregation = new MissingAggregation('foo');
        $aggregation->setField('bar');
        $result = $aggregation->getArray();
        $this->assertEquals('bar', $result['field']);
    }

    public function testMissingAggregationGetType(): void
    {
        $aggregation = new MissingAggregation('bar');
        $result = $aggregation->getType();
        $this->assertEquals('missing', $result);
    }
}
