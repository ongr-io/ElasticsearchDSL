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
 * Class representing date range aggregation.
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
     * @return RangeAggregation
     *
     * @throws \LogicException
     */
    public function addRange($from = null, $to = null)
    {
        if ($from === null && $to === null) {
            throw new \LogicException('Missing range');
        } elseif ($from === null) {
            $this->ranges = [['to' => $to]];
        } elseif ($to === null) {
            $this->ranges = [['from' => $from]];
        } else {
            $this->ranges = [['from' => $from], ['to' => $to]];
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        if ($this->getField() && $this->getFormat() && $this->ranges) {
            $data = [
                'format' => $this->getFormat(),
                'field' => $this->getField(),
                'ranges' => array_values($this->ranges),
            ];

            return $data;
        }
        throw new \LogicException('Date range aggregation must have field and format set.');
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'date_range';
    }
}
