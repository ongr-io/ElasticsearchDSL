<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Aggregation;

use ONGR\ElasticsearchBundle\DSL\Aggregation\PercentilesAggregation;

class PercentilesAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests if PercentilesAggregation#getArray throws exception when expected.
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage Percentiles aggregation must have field or script set.
     */
    public function testPercentilesAggregationGetArrayException()
    {
        $aggregation = new PercentilesAggregation('bar');
        $aggregation->getArray();
    }
}
