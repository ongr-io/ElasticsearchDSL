<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Sort;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Holds all the values required for basic sorting.
 */
class GeoDistanceSort implements BuilderInterface
{
    use ParametersTrait;

    const ASC  = 'asc';
    const DESC = 'desc';

    const ARC   = 'arc';
    const PLANE = 'plane';

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $order;

    /**
     * @var string
     */
    private $distanceType;

    /**
     * @var string
     */
    private $location;

    /**
     * @var BuilderInterface
     */
    private $nestedFilter;

    /**
     * @param string $field Field name.
     * @param string|array $location The location to measure the distance from. The possible representations can be found here: https://www.elastic.co/guide/en/elasticsearch/reference/current/geo-point.html
     * @param string $order Order direction.
     * @param array $params Params that can be set to field sort.
     */
    public function __construct($field, $location, $order = null, $params = [])
    {
        $this->field    = $field;
        $this->order    = $order;
        $this->location = $location;
        $this->setParameters($params);
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     *
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param string $order
     *
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return BuilderInterface
     */
    public function getNestedFilter()
    {
        return $this->nestedFilter;
    }

    /**
     * @param BuilderInterface $nestedFilter
     *
     * @return $this
     */
    public function setNestedFilter(BuilderInterface $nestedFilter)
    {
        $this->nestedFilter = $nestedFilter;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistanceType()
    {
        return $this->distanceType;
    }

    /**
     * @param string $distanceType
     * @return GeoSort
     */
    public function setDistanceType($distanceType)
    {
        $this->distanceType = $distanceType;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return GeoSort
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Returns element type.
     *
     * @return string
     */
    public function getType()
    {
        return 'sort';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        if ($this->field) {
            $this->addParameter($this->field, $this->location);
        }

        if ($this->order) {
            $this->addParameter('order', $this->order);
        }

        if ($this->nestedFilter) {
            $this->addParameter('nested', $this->nestedFilter->toArray());
        }

        $output = [
            '_geo_distance' => !$this->getParameters() ? new \stdClass() : $this->getParameters(),
        ];

        return $output;
    }
}
