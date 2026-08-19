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

namespace ONGR\ElasticsearchDSL\Query\Compound;

use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Represents Elasticsearch "boosting" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-boosting-query.html
 */
class BoostingQuery implements BuilderInterface
{
    public function __construct(
        private BuilderInterface $positive,
        private BuilderInterface $negative,
        private int|float $negativeBoost
    ) {

    }

    public function getType(): string
    {
        return 'boosting';
    }

    public function toArray(): array
    {
        $query = [
            'positive' => $this->positive->toArray(),
            'negative' => $this->negative->toArray(),
            'negative_boost' => $this->negativeBoost,
        ];

        return [$this->getType() => $query];
    }
}
