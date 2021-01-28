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

namespace ONGR\ElasticsearchDSL\Tests\Unit\Unit\SearchEndpoint;

use ONGR\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint;
use ONGR\ElasticsearchDSL\SearchEndpoint\SearchEndpointFactory;
use RuntimeException;

/**
 * Unit test class for search endpoint factory.
 */
class SearchEndpointFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testGet(): void
    {
        $this->expectException(RuntimeException::class);

        SearchEndpointFactory::get('foo');
    }

    public function testFactory(): void
    {
        $searchEndpoint = SearchEndpointFactory::get(AggregationsEndpoint::NAME);

        $this->assertInstanceOf(AggregationsEndpoint::class, $searchEndpoint);
    }
}
