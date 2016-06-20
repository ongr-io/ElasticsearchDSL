<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Pipeline;

class AvgBucketAggregation extends AbstractPipelineAggregation
{
    /**
     * @param string $name
     * @param string $bucketsPath
     * @param string $gapPolicy
     */
    public function __construct($name, $bucketsPath, $gapPolicy = null)
    {
        parent::__construct($name);
        $this->setBucketsPath($bucketsPath);
        !$gapPolicy ? : $this->setGapPolicy($gapPolicy);
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        return array_filter(
            [
                'buckets_path' => $this->getBucketsPath(),
                'gap_policy' => $this->getGapPolicy(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getPipelineFamily()
    {
        return 'sibling';
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'avg_bucket';
    }
}
