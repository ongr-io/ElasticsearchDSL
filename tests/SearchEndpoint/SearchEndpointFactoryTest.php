<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\SearchEndpoint;

use ONGR\ElasticsearchBundle\DSL\SearchEndpoint\SearchEndpointFactory;

/**
 * Unit test class for search endpoint factory.
 */
class SearchEndpointFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests get method exception.
     *
     * @expectedException \RuntimeException
     */
    public function testGet()
    {
        SearchEndpointFactory::get('foo');
    }
}
