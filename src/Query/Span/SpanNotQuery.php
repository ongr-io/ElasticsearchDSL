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
 * Elasticsearch Span not query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-not-query.html
 */
class SpanNotQuery implements SpanQueryInterface
{
    use ParametersTrait;

    public function __construct(
        private SpanQueryInterface $include,
        private SpanQueryInterface $exclude,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'span_not';
    }

    public function toArray(): array
    {
        $query = [
            'include' => $this->include->toArray(),
            'exclude' => $this->exclude->toArray(),
        ];

        return [$this->getType() => $this->processArray($query)];
    }
}
