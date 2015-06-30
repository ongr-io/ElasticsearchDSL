<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL;

use ONGR\ElasticsearchDSL\Search;

/**
 * Test for Search.
 */
class SearchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Search constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf('ONGR\ElasticsearchDSL\Search', new Search());
    }
}
