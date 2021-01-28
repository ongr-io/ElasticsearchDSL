<?php

namespace ONGR\ElasticsearchDSL\Query\Joining;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "has_child" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-has-child-query.html
 */
class HasChildQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private string $type,
        private BuilderInterface $query,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'has_child';
    }

    public function toArray(): array
    {
        $query = [
            'type' => $this->type,
            'query' => $this->query->toArray(),
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
