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

namespace ONGR\ElasticsearchDSL\Query\Span;

use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Elasticsearch span or query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-or-query.html
 */
class SpanOrQuery implements SpanQueryInterface
{
    use ParametersTrait;

    private array $queries = [];

    public function __construct(array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    public function addQuery(SpanQueryInterface $query): static
    {
        $this->queries[] = $query;

        return $this;
    }

    public function getQueries(): array
    {
        return $this->queries;
    }

    public function getType(): string
    {
        return 'span_or';
    }

    public function toArray(): array
    {
        $query = [];
        foreach ($this->queries as $type) {
            $query['clauses'][] = $type->toArray();
        }
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
