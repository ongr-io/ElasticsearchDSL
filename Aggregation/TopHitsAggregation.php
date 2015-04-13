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
use ONGR\ElasticsearchBundle\DSL\Sort\Sorts;

/**
 * Top hits aggregation.
 */
class TopHitsAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * @var int Number of top matching hits to return per bucket.
     */
    private $size;

    /**
     * @var int The offset from the first result you want to fetch.
     */
    private $from;

    /**
     * @var Sorts How the top matching hits should be sorted.
     */
    private $sort;

    /**
     * Constructor for top hits.
     *
     * @param string     $name Aggregation name.
     * @param null|int   $size Number of top matching hits to return per bucket.
     * @param null|int   $from The offset from the first result you want to fetch.
     * @param null|Sorts $sort How the top matching hits should be sorted.
     */
    public function __construct($name, $size = null, $from = null, $sort = null)
    {
        parent::__construct($name);
        $this->setFrom($from);
        $this->setSize($size);
        $this->setSort($sort);
    }

    /**
     * Return from.
     *
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set from.
     *
     * @param int $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * Return sort.
     *
     * @return Sorts
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set sort.
     *
     * @param Sorts $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * Set size.
     *
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Return size.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'top_hits';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $data = new \stdClass();

        $filteredData = $this->getFilteredData();
        foreach ($filteredData as $key => $value) {
            $data->{$key} = $value;
        }

        return $data;
    }

    /**
     * Filters the data.
     *
     * @return array
     */
    private function getFilteredData()
    {
        $fd = array_filter(
            [
                'sort' => $this->getSort() ? $this->getSort()->toArray() : [],
                'size' => $this->getSize(),
                'from' => $this->getFrom(),
            ],
            function ($val) {
                return (($val || is_array($val) || ($val || is_numeric($val))));
            }
        );

        return $fd;
    }
}
