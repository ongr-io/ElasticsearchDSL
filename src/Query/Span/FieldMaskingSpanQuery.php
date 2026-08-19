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
 * Elasticsearch span within query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-field-masking-query.html
 */
class FieldMaskingSpanQuery implements SpanQueryInterface
{
    use ParametersTrait;

    public function __construct(
        private string $field,
        private SpanQueryInterface $query
    ) {
        $this->setQuery($query);
        $this->setField($field);
    }

    public function getQuery(): SpanQueryInterface
    {
        return $this->query;
    }

    public function setQuery(SpanQueryInterface $query): static
    {
        $this->query = $query;

        return $this;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(string $field): static
    {
        $this->field = $field;

        return $this;
    }

    public function toArray(): array
    {
        $output = [
            'query' => $this->getQuery()->toArray(),
            'field' => $this->getField(),
        ];

        $output = $this->processArray($output);

        return [$this->getType() => $output];
    }

    public function getType(): string
    {
        return 'field_masking_span';
    }
}
