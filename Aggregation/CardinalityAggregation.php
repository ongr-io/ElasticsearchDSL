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

use ONGR\ElasticsearchBundle\DSL\Aggregation\Type\MetricTrait;

/**
 * Difference values counter.
 */
class CardinalityAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * @var int
     */
    private $precisionThreshold;

    /**
     * @var bool
     */
    private $rehash;

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        if (!$this->getField()) {
            return new \stdClass();
        }

        $out['field'] = $this->getField();
        if ($this->getPrecisionThreshold()) {
            $out['precision_threshold'] = $this->getPrecisionThreshold();
        }

        if ($this->isRehash() !== null) {
            $out['rehash'] = $this->isRehash();
        }

        return $out;
    }

    /**
     * Precision threshold.
     *
     * @param int $precision Precision Threshold.
     */
    public function setPrecisionThreshold($precision)
    {
        $this->precisionThreshold = $precision;
    }

    /**
     * @return int
     */
    public function getPrecisionThreshold()
    {
        return $this->precisionThreshold;
    }

    /**
     * @return bool
     */
    public function isRehash()
    {
        return $this->rehash;
    }

    /**
     * @param bool $rehash
     */
    public function setRehash($rehash)
    {
        $this->rehash = $rehash;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'cardinality';
    }
}
