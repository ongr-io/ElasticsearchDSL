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
 * Class representing date range aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-daterange-aggregation.html
 */
class DateRangeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var string
     */
    private $format;

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $name
     * @param string $field
     * @param string $format
     * @param array  $ranges
     */
    public function __construct($name, $field = null, $format = null, array $ranges = [])
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setFormat($format);
        foreach ($ranges as $range) {
            $from = isset($range['from']) ? $range['from'] : null;
            $to = isset($range['to']) ? $range['to'] : null;
            $key = isset($range['key']) ? $range['key'] : null;
            $this->addRange($from, $to, $key);
        }
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @var array
     */
    private $ranges = [];

    /**
     * Add range to aggregation.
     *
     * @param string|null $from
     * @param string|null $to
     *
     * @return $this
     *
     * @throws \LogicException
     */
    public function addRange($from = null, $to = null, $key = null)
    {
        $range = array_filter(
            [
                'from' => $from,
                'to' => $to,
                'key' => $key,
            ],
            function ($v) {
                return !is_null($v);
            }
        );

        if (empty($range)) {
            throw new \LogicException('Either from or to must be set. Both cannot be null.');
        }

        $this->ranges[] = $range;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        if ($this->getField() && $this->getFormat() && !empty($this->ranges)) {
            $data = [
                'format' => $this->getFormat(),
                'field' => $this->getField(),
                'ranges' => $this->ranges,
            ];

            return $data;
        }
        throw new \LogicException('Date range aggregation must have field, format set and range added.');
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'date_range';
    }
}
