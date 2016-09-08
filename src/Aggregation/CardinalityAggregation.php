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

use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;
use ONGR\ElasticsearchDSL\ScriptAwareTrait;

/**
 * Difference values counter.
 */
class CardinalityAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    /**
     * @param string $name
     * @param string $field
     * @param string $script
     */
    public function __construct($name, $field = null, $script = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setScript($script);
    }

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
        $out = array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
                'precision_threshold' => $this->getPrecisionThreshold(),
                'rehash' => $this->isRehash(),
            ],
            function ($val) {
                return ($val || is_bool($val));
            }
        );

        $this->checkRequiredFields($out);

        return $out;
    }

    /**
     * Precision threshold.
     *
     * @param int $precision Precision Threshold.
     *
     * @return $this
     */
    public function setPrecisionThreshold($precision)
    {
        $this->precisionThreshold = $precision;

        return $this;
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
     *
     * @return $this
     */
    public function setRehash($rehash)
    {
        $this->rehash = $rehash;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'cardinality';
    }

    /**
     * Checks if required fields are set.
     *
     * @param array $fields
     *
     * @throws \LogicException
     */
    private function checkRequiredFields($fields)
    {
        if (!array_key_exists('field', $fields) && !array_key_exists('script', $fields)) {
            throw new \LogicException('Cardinality aggregation must have field or script set.');
        }
    }
}
