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

/**
 * Class representing Percentiles Bucket Pipeline Aggregation.
 *
 * @link https://goo.gl/bqi7m5
 */
class PercentilesBucketAggregation extends AbstractPipelineAggregation
{
    /**
     * @var array
     */
    private $percents;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'percentiles_bucket';
    }

    /**
     * @return array
     */
    public function getPercents()
    {
        return $this->percents;
    }

    /**
     * @param array $percents
     */
    public function setPercents(array $percents)
    {
        $this->percents = $percents;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $data = ['buckets_path' => $this->getBucketsPath()];

        if ($this->getPercents()) {
            $data['percents'] = $this->getPercents();
        }

        return $data;
    }
}
