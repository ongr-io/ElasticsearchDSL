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
 * Class representing geo bounds aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.3/search-aggregations-bucket-sampler-aggregation.html
 */
class SamplerAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * Defines how many results will be received from each shard
     * @param string $shardSize
     */
    private $shardSize;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param int    $shardSize
     */
    public function __construct($name, $field = null, $shardSize = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setShardSize($shardSize);
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
    public function getType()
    {
        return 'sampler';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $out = array_filter(
            [
                'field' => $this->getField(),
                'shard_size' => $this->getShardSize(),
            ]
        );

        return $out;
    }
}
