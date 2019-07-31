<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param int    $precision
     * @param int    $size
     * @param int    $shardSize
     */
    public function __construct($name, $field = null, $precision = null, $size = null, $shardSize = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setPrecision($precision);
        $this->setSize($size);
        $this->setShardSize($shardSize);
    }

    /**
     * @return int
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * @param int $precision
     *
     * @return $this
     */
    public function setPrecision($precision)
    {
        $this->precision = $precision;

        return $this;
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
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
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
     *
     * @return $this
     */
    public function setShardSize($shardSize)
    {
        $this->shardSize = $shardSize;

        return $this;
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
