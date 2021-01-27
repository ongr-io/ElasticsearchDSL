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

namespace ONGR\ElasticsearchDSL\Query\Joining;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "nested" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-nested-query.html
 */
class NestedQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private string $path,
        private BuilderInterface $query,
        array $parameters = []
    ) {
        $this->parameters = $parameters;
    }

    public function getType(): string
    {
        return 'nested';
    }

    public function toArray(): array
    {
        return [
            $this->getType() => $this->processArray(
                [
                    'path' => $this->path,
                    'query' => $this->query->toArray(),
                ]
            )
        ];
    }

    public function getQuery(): BuilderInterface
    {
        return $this->query;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
