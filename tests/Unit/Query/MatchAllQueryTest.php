<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query;

use ONGR\ElasticsearchDSL\Query\MatchAllQuery;

class MatchAllQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArrayWhenThereAreNoParams()
    {
        $query = new MatchAllQuery();
        $this->assertEquals(['match_all' => new \stdClass()], $query->toArray());
    }

    /**
     * Tests toArray().
     */
    public function testToArrayWithParams()
    {
        $params = ['boost' => 5];
        $query = new MatchAllQuery($params);
        $this->assertEquals(['match_all' => $params], $query->toArray());
    }
}
