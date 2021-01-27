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

namespace ONGR\ElasticsearchDSL\Query\FullText;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "simple_query_string" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-simple-query-string-query.html
 */
class SimpleQueryStringQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(private string $query, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'simple_query_string';
    }

    public function toArray(): array
    {
        $query = [
            'query' => $this->query,
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
