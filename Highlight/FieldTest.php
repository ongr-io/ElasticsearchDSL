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

use ONGR\ElasticsearchBundle\DSL\Bool\Bool;
use ONGR\ElasticsearchBundle\DSL\Filter\MissingFilter;

/**
 * Unit test for Bool.
 */
class BoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests isRelevant method.
     */
    public function testIsRelevant()
    {
        $bool = new Bool();
        $this->assertEquals(false, $bool->isRelevant());

        $bool->addToBool(new MissingFilter('test'));
        $this->assertEquals(true, $bool->isRelevant());
    }
}
