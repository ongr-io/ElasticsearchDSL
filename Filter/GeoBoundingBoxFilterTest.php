<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Filter;

use ONGR\ElasticsearchBundle\DSL\Filter\GeoBoundingBoxFilter;

class GeoBoundingBoxFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if exception is thrown when geo points are not set.
     *
     * @expectedException \LogicException
     */
    public function testGeoBoundBoxFilterException()
    {
        $filter = new GeoBoundingBoxFilter('location', []);
        $filter->toArray();
    }
}
