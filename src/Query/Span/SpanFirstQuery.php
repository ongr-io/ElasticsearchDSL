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
 * Elasticsearch span first query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-first-query.html
 */
class SpanFirstQuery implements SpanQueryInterface
{
    use ParametersTrait;

    public function __construct(
        private SpanQueryInterface $query,
        private int $end,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }


    public function getType(): string
    {
        return 'span_first';
    }

    public function toArray(): array
    {
        $query = [];
        $query['match'] = $this->query->toArray();
        $query['end'] = $this->end;
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
