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

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;

/**
 * Abstraction class for pipeline aggregations
 */
abstract class AbstractPipelineAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * @var string
     */
    private $bucketsPath;

    /**
     * @var string
     */
    private $gapPolicy = 'skip';

    /**
     * @return string
     */
    abstract public function getPipelineFamily();

    /**
     * @return string
     */
    public function getBucketsPath()
    {
        return $this->bucketsPath;
    }

    /**
     * @param string $bucketsPath
     */
    public function setBucketsPath($bucketsPath)
    {
        $this->bucketsPath = $bucketsPath;
    }

    /**
     * @return string
     */
    public function getGapPolicy()
    {
        return $this->gapPolicy;
    }

    /**
     * @param string $gapPolicy
     */
    public function setGapPolicy($gapPolicy)
    {
        if ($gapPolicy != 'skip' || $gapPolicy != 'insert_zeros') {
            throw new \LogicException(
                'Gap policy of '.$this->getName().
                ' aggregation can only be `skip` or `insert_zeros`.'
            );
        } else {
            $this->gapPolicy = $gapPolicy;
        }
    }
}
