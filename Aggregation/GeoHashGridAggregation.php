<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Aggregation;

use ONGR\ElasticsearchBundle\DSL\Aggregation\Type\BucketingTrait;

/**
 * Class representing geohash grid aggregation.
 */
class GeoHashGridAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var int
     */
    private $precision;

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $shardSize;

    /**
     * @return int
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * @param int $precision
     */
    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getShardSize()
    {
        return $this->shardSize;
    }

    /**
     * @param int $shardSize
     */
    public function setShardSize($shardSize)
    {
        $this->shardSize = $shardSize;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
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

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'geohash_grid';
    }
}
