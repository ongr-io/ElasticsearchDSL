<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query\TermLevel;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "term" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-term-query.html
 */
class TermQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private string $field,
        private string $value,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'term';
    }

    public function toArray(): array
    {
        $query = $this->processArray();

        if (empty($query)) {
            $query = $this->value;
        } else {
            $query['value'] = $this->value;
        }

        $output = [
            $this->field => $query,
        ];

        return [$this->getType() => $output];
    }
}
