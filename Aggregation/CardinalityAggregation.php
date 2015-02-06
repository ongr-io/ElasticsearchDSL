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
     * @var string
     */
    private $script;

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $out = [];

        if ($this->getField()) {
            $out['field'] = $this->getField();
        } elseif ($this->getScript()) {
            $out['script'] = $this->getScript();
        } else {
            throw new \LogicException('Cardinality aggregation must have field or script set.');
        }

        if ($this->getPrecisionThreshold()) {
            $out['precision_threshold'] = $this->getPrecisionThreshold();
        }

        if ($this->isRehash()) {
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
     * @return string
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @param string $script
     */
    public function setScript($script)
    {
        $this->script = $script;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'cardinality';
    }
}
