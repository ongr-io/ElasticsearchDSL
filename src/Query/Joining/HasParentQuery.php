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
 * Represents Elasticsearch "has_parent" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-has-parent-query.html
 */
class HasParentQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private string $parentType,
        private BuilderInterface $query,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'has_parent';
    }

    public function toArray(): array
    {
        $query = [
            'parent_type' => $this->parentType,
            'query' => $this->query->toArray(),
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
