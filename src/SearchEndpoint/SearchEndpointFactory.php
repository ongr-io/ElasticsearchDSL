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

namespace ONGR\ElasticsearchDSL\SearchEndpoint;

class SearchEndpointFactory
{
    /**
     * @var array Holds namespaces for endpoints.
     */
    private static $endpoints = [
        'query' => 'ONGR\ElasticsearchDSL\SearchEndpoint\QueryEndpoint',
        'post_filter' => 'ONGR\ElasticsearchDSL\SearchEndpoint\PostFilterEndpoint',
        'sort' => 'ONGR\ElasticsearchDSL\SearchEndpoint\SortEndpoint',
        'highlight' => 'ONGR\ElasticsearchDSL\SearchEndpoint\HighlightEndpoint',
        'aggregations' => 'ONGR\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint',
        'suggest' => 'ONGR\ElasticsearchDSL\SearchEndpoint\SuggestEndpoint',
        'inner_hits' => 'ONGR\ElasticsearchDSL\SearchEndpoint\InnerHitsEndpoint',
    ];

    public static function get(string $type): SearchEndpointInterface
    {
        if (!array_key_exists($type, self::$endpoints)) {
            throw new \RuntimeException('Endpoint does not exist.');
        }

        return new self::$endpoints[$type]();
    }
}
