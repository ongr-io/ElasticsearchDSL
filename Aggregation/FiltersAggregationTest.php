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

use ONGR\ElasticsearchBundle\DSL\Aggregation\FiltersAggregation;

/**
 * Unit test for filters aggregation.
 */
class FiltersAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if exception is thrown when not anonymous filter is without name.
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage In not anonymous filters filter name must be set.
     */
    public function testIfExceptionIsThrown()
    {
        $mock = $this->getMockBuilder('ONGR\ElasticsearchBundle\DSL\BuilderInterface')->getMock();
        $aggregation = new FiltersAggregation('test_agg');
        $aggregation->addFilter($mock);
    }
}
