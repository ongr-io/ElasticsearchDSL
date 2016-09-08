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

/**
 * Class representing Histogram aggregation.
 *
 * @link https://goo.gl/hGCdDd
 */
class DateHistogramAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var string
     */
    protected $interval;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param string $interval
     */
    public function __construct(
        $name,
        $field = null,
        $interval = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setInterval($interval);
    }

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param string $interval
     *
     * @return $this
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'date_histogram';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        if (!$this->getField() || !$this->getInterval()) {
            throw new \LogicException('Date histogram aggregation must have field and interval set.');
        }

        $out = [
            'field' => $this->getField(),
            'interval' => $this->getInterval(),
        ];
        $out = $this->processArray($out);

        return $out;
    }
}
