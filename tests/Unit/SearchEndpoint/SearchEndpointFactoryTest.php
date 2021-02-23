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

use ONGR\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint;
use ONGR\ElasticsearchDSL\SearchEndpoint\SearchEndpointFactory;
use ONGR\ElasticsearchDSL\SearchEndpoint\SearchEndpointInterface;

/**
 * Unit test class for search endpoint factory.
 */
class SearchEndpointFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests get method exception.
     */
    public function testGet()
    {
        $this->expectException(\RuntimeException::class);
        SearchEndpointFactory::get('foo');
    }

    /**
     * Tests if factory can create endpoint.
     */
    public function testFactory()
    {
        $endpoint = SearchEndpointFactory::get(AggregationsEndpoint::NAME);
        $this->assertInstanceOf(SearchEndpointInterface::class, $endpoint);
    }
}
