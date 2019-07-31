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
 * Class representing Histogram aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-histogram-aggregation.html
 */
class HistogramAggregation extends AbstractAggregation
{
    use BucketingTrait;

    const DIRECTION_ASC = 'asc';
    const DIRECTION_DESC = 'desc';

    /**
     * @var int
     */
    protected $interval;

    /**
     * @var int
     */
    protected $minDocCount;

    /**
     * @var array
     */
    protected $extendedBounds;

    /**
     * @var string
     */
    protected $orderMode;

    /**
     * @var string
     */
    protected $orderDirection;

    /**
     * @var bool
     */
    protected $keyed;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param int    $interval
     * @param int    $minDocCount
     * @param string $orderMode
     * @param string $orderDirection
     * @param int    $extendedBoundsMin
     * @param int    $extendedBoundsMax
     * @param bool   $keyed
     */
    public function __construct(
        $name,
        $field = null,
        $interval = null,
        $minDocCount = null,
        $orderMode = null,
        $orderDirection = self::DIRECTION_ASC,
        $extendedBoundsMin = null,
        $extendedBoundsMax = null,
        $keyed = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setInterval($interval);
        $this->setMinDocCount($minDocCount);
        $this->setOrder($orderMode, $orderDirection);
        $this->setExtendedBounds($extendedBoundsMin, $extendedBoundsMax);
        $this->setKeyed($keyed);
    }

    /**
     * @return bool
     */
    public function isKeyed()
    {
        return $this->keyed;
    }

    /**
     * Get response as a hash instead keyed by the buckets keys.
     *
     * @param bool $keyed
     *
     * @return $this
     */
    public function setKeyed($keyed)
    {
        $this->keyed = $keyed;

        return $this;
    }

    /**
     * Sets buckets ordering.
     *
     * @param string $mode
     * @param string $direction
     *
     * @return $this
     */
    public function setOrder($mode, $direction = self::DIRECTION_ASC)
    {
        $this->orderMode = $mode;
        $this->orderDirection = $direction;

        return $this;
    }

    /**
     * @return array
     */
    public function getOrder()
    {
        if ($this->orderMode && $this->orderDirection) {
            return [$this->orderMode => $this->orderDirection];
        } else {
            return null;
        }
    }

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param int $interval
     *
     * @return $this
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinDocCount()
    {
        return $this->minDocCount;
    }

    /**
     * Set limit for document count buckets should have.
     *
     * @param int $minDocCount
     *
     * @return $this
     */
    public function setMinDocCount($minDocCount)
    {
        $this->minDocCount = $minDocCount;

        return $this;
    }

    /**
     * @return array
     */
    public function getExtendedBounds()
    {
        return $this->extendedBounds;
    }

    /**
     * @param int $min
     * @param int $max
     *
     * @return $this
     */
    public function setExtendedBounds($min = null, $max = null)
    {
        $bounds = array_filter(
            [
                'min' => $min,
                'max' => $max,
            ],
            'strlen'
        );
        $this->extendedBounds = $bounds;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'histogram';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $out = array_filter(
            [
                'field' => $this->getField(),
                'interval' => $this->getInterval(),
                'min_doc_count' => $this->getMinDocCount(),
                'extended_bounds' => $this->getExtendedBounds(),
                'keyed' => $this->isKeyed(),
                'order' => $this->getOrder(),
            ],
            function ($val) {
                return ($val || is_numeric($val));
            }
        );
        $this->checkRequiredParameters($out, ['field', 'interval']);

        return $out;
    }

    /**
     * Checks if all required parameters are set.
     *
     * @param array $data
     * @param array $required
     *
     * @throws \LogicException
     */
    protected function checkRequiredParameters($data, $required)
    {
        if (count(array_intersect_key(array_flip($required), $data)) !== count($required)) {
            throw new \LogicException('Histogram aggregation must have field and interval set.');
        }
    }
}
