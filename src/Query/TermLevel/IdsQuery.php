<?php

namespace ONGR\ElasticsearchDSL\Query\TermLevel;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "ids" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-ids-query.html
 */
class IdsQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(private array $values, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'ids';
    }

    public function toArray(): array
    {
        $query = [
            'values' => $this->values,
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
