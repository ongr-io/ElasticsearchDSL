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

namespace ONGR\ElasticsearchDSL\Query\TermLevel;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "prefix" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-prefix-query.html
 */
class PrefixQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(protected string $field, protected string $value, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'prefix';
    }

    public function toArray(): array
    {
        $query = [
            'value' => $this->value,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return [$this->getType() => $output];
    }
}
