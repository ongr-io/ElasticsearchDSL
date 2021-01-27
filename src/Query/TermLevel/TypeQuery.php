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

/**
 * Represents Elasticsearch "type" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-type-query.html
 */
class TypeQuery implements BuilderInterface
{
    public function __construct(private string $type)
    {
    }

    public function getType(): string
    {
        return 'type';
    }

    public function toArray(): array
    {
        return [
            $this->getType() => [
                'value' => $this->type,
            ],
        ];
    }
}
