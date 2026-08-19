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
 * Class representing geohash grid aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-geohashgrid-aggregation.html
 */
class GeoHashGridAggregation extends AbstractAggregation
{
    use BucketingTrait;

    public function __construct(
        private string $name,
        private ?string $field = null,
        private ?int $precision = null,
        private ?int $size = null,
        private ?int $shardSize = null
    ) {
        parent::__construct($name);
    }

    public function getPrecision(): ?int
    {
        return $this->precision;
    }

    public function setPrecision(?int $precision): static
    {
        $this->precision = $precision;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): static
    {
        $this->size = $size;

        return $this;
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

    public function getArray(): array
    {
        $data = [];

        if ($this->getField()) {
            $data['field'] = $this->getField();
        } else {
            throw new \LogicException('Geo bounds aggregation must have a field set.');
        }

        if ($this->getPrecision()) {
            $data['precision'] = $this->getPrecision();
        }

        if ($this->getSize()) {
            $data['size'] = $this->getSize();
        }

        if ($this->getShardSize()) {
            $data['shard_size'] = $this->getShardSize();
        }

        return $data;
    }

    public function getType(): string
    {
        return 'geohash_grid';
    }
}
