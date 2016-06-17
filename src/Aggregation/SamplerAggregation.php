<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;

class SamplerAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * Defines how many
     * @param string $shardSize
     */
    private $shardSize;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param int    $shardSize
     * @param array  $parameters
     */
    public function __construct(
        $name,
        $field = null,
        $shardSize = null,
        $parameters = []
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setShardSize($shardSize);
        $this->setParameters($parameters);
    }

    /**
     * @return mixed
     */
    public function getShardSize()
    {
        return $this->shardSize;
    }

    /**
     * @param mixed $shardSize
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
            ],
            function ($val) {
                return $val;
            }
        );
        return $this->processArray($out);
    }
}