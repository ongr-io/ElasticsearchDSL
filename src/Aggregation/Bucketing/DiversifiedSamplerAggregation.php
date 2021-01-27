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
 * Class representing geo diversified sampler aggregation.
 *
 * @link https://goo.gl/yzXvqD
 */
class DiversifiedSamplerAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * DiversifiedSamplerAggregation constructor.
     *
     * @param string $name Aggregation name
     * @param string $field Elasticsearch field name
     * @param int $shardSize Shard size, by default it's 100
     */
    public function __construct(
        protected string $name,
        protected ?string $field = null,
        protected ?int $shardSize = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setShardSize($shardSize);
    }

    public function getShardSize(): int
    {
        return $this->shardSize;
    }

    public function setShardSize(int $shardSize): static
    {
        $this->shardSize = $shardSize;

        return $this;
    }

    public function getType(): string
    {
        return 'diversified_sampler';
    }

    protected function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
                'shard_size' => $this->getShardSize(),
            ]
        );
    }
}
