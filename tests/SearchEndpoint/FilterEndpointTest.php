<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\SearchEndpoint;

use ONGR\ElasticsearchDSL\SearchEndpoint\FilterEndpoint;

/**
 * Class FilterEndpointTest.
 */
class FilterEndpointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf(
            'ONGR\ElasticsearchDSL\SearchEndpoint\FilterEndpoint',
            new FilterEndpoint()
        );
    }
}
