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
 * Represents Elasticsearch "regexp" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-regexp-query.html
 */
class RegexpQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private string $field,
        private string $regexpValue,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'regexp';
    }

    public function toArray(): array
    {
        $query = [
            'value' => $this->regexpValue,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return [$this->getType() => $output];
    }
}
