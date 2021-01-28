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

namespace ONGR\ElasticsearchDSL\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;

/**
 * Class representing geo bounds aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.3/search-aggregations-bucket-sampler-aggregation.html
 */
class SamplerAggregation extends AbstractAggregation
{
    use BucketingTrait;

    public function __construct(
        private string $name,
        private ?string $field = null,
        private ?int $shardSize = null
    ) {
        parent::__construct($name);

        $this->setField($field);
    }

    public function getShardSize(): ?int
    {
        return $this->shardSize;
    }

    public function setShardSize(?int $shardSize): static
    {
        $this->shardSize = $shardSize;

        return $this;
    }

    public function getType(): string
    {
        return 'sampler';
    }

    public function getArray(): array
    {
       return array_filter(
            [
                'field' => $this->getField(),
                'shard_size' => $this->getShardSize(),
            ]
        );

    }
}
