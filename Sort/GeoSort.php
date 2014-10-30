<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Sort;

/**
 * A special type of sorting by distance.
 */
class GeoSort extends AbstractSort
{
    /**
     * Possible types.
     *
     * Examples:
     * [-70, 40]
     * ["lat" : 40, "lon" : -70]
     * "-70,40"
     *
     * @var string|array
     */
    protected $location;

    /**
     * Units in which to measure distance.
     *
     * @var string
     */
    protected $unit;

    /**
     * Constructor for geo sort.
     *
     * @param string       $field    Field name.
     * @param array|string $location Possible types examples:
     *                               [-70, 40]
     *                               ["lat" : 40, "lon" : -70]
     *                               "-70,40".
     * @param string       $order    Order.
     * @param string       $unit     Units for measuring the distance.
     * @param string       $mode     Mode.
     */
    public function __construct($field, $location, $order = self::ORDER_DESC, $unit = null, $mode = null)
    {
        $this->setLocation($location);
        $this->setUnit($unit);
        parent::__construct($field, $order, $mode);
    }

    /**
     * @param string $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param array|string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return array|string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return string
     */
    final public function getType()
    {
        return '_geo_distance';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $value = parent::toArray();

        if ($this->getUnit() !== null) {
            $value['unit'] = $this->getUnit();
        }

        $value[$this->getField()] = $this->getLocation();

        return $value;
    }
}
