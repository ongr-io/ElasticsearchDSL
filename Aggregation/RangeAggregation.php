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

use ONGR\ElasticsearchBundle\DSL\Aggregation\Type\BucketingTrait;

/**
 * Class representing RangeAggregation.
 */
class RangeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var array
     */
    protected $ranges = [];

    /**
     * @var bool
     */
    protected $keyed = false;

    /**
     * Sets if result buckets should be keyed.
     *
     * @param bool $keyed
     */
    public function setKeyed($keyed)
    {
        $this->keyed = $keyed;
    }

    /**
     * Add range to aggregation.
     *
     * @param mixed  $from
     * @param mixed  $to
     * @param string $key
     */
    public function addRange($from = null, $to = null, $key = '')
    {
        $range  = [];

        if (!empty($from)) {
            $range['from'] = $from;
        }

        if (!empty($to)) {
            $range['to'] = $to;
        }

        if ($this->keyed && !empty($key)) {
            $range['key'] = $key;
        }

        $this->ranges[] = $range;
    }

    /**
     * Remove range from aggregation. Returns true on success.
     *
     * @param mixed  $from
     * @param mixed  $to
     * @param string $searchKey
     *
     * @return bool
     */
    public function removeRange($from, $to, $searchKey = '')
    {
        foreach ($this->ranges as $key => $range) {
            if (($range['from'] == $from && $range['to'] == $to)
                || (!empty($searchKey) && $range['key'] == $searchKey)
            ) {
                unset($this->ranges[$key]);

                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $data = [
            'keyed' => $this->keyed,
            'ranges' => $this->ranges,
        ];

        if ($this->getField()) {
            $data['field'] = $this->getField();
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'range';
    }
}
