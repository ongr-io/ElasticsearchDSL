<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\SearchEndpoint;

/**
 * Factory for search endpoints.
 */
class SearchEndpointFactory
{
    /**
     * @var array Holds namespaces for endpoints.
     */
    private static $endpoints = [
        'query' => 'ONGR\ElasticsearchBundle\DSL\SearchEndpoint\QueryEndpoint',
        'filter' => 'ONGR\ElasticsearchBundle\DSL\SearchEndpoint\FilterEndpoint',
        'post_filter' => 'ONGR\ElasticsearchBundle\DSL\SearchEndpoint\PostFilterEndpoint',
        'sort' => 'ONGR\ElasticsearchBundle\DSL\SearchEndpoint\SortEndpoint',
        'highlight' => 'ONGR\ElasticsearchBundle\DSL\SearchEndpoint\HighlightEndpoint',
        'aggregations' => 'ONGR\ElasticsearchBundle\DSL\SearchEndpoint\AggregationsEndpoint',
        'suggest' => 'ONGR\ElasticsearchBundle\DSL\SearchEndpoint\SuggestEndpoint',
    ];

    /**
     * Returns a search endpoint instance.
     *
     * @param string $type Type of endpoint.
     *
     * @return SearchEndpointInterface
     *
     * @throws \RuntimeException Endpoint does not exist.
     * @throws \DomainException  Endpoint is not implementing SearchEndpointInterface
     */
    public static function get($type)
    {
        if (!array_key_exists($type, self::$endpoints)) {
            throw new \RuntimeException();
        }
        $endpoint = new self::$endpoints[$type]();

        if ($endpoint instanceof SearchEndpointInterface) {
            return $endpoint;
        }

        throw new \DomainException();
    }
}
