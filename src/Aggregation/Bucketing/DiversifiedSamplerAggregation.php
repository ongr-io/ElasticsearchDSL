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

    public function __construct(
        private string $name,
        private ?string $field = null,
        private ?int $shardSize = null
    ) {
        parent::__construct($name);
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
