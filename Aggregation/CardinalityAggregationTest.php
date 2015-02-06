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

use ONGR\ElasticsearchBundle\DSL\Aggregation\CardinalityAggregation;

/**
 * Unit test for cardinality aggregation.
 */
class CardinalityAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests if CardinalityAggregation#getArray throws exception when expected.
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage Cardinality aggregation must have field or script set.
     */
    public function testGetArrayException()
    {
        $aggregation = new CardinalityAggregation('bar');
        $aggregation->getArray();
    }
}
