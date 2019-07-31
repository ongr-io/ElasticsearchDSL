<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;

/**
 * Class representing geo bounds aggregation.
 *
 * @link http://goo.gl/aGqw7Y
 */
class GeoBoundsAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * @var bool
     */
    private $wrapLongitude = true;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param bool   $wrapLongitude
     */
    public function __construct($name, $field = null, $wrapLongitude = true)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setWrapLongitude($wrapLongitude);
    }

    /**
     * @return bool
     */
    public function isWrapLongitude()
    {
        return $this->wrapLongitude;
    }

    /**
     * @param bool $wrapLongitude
     *
     * @return $this
     */
    public function setWrapLongitude($wrapLongitude)
    {
        $this->wrapLongitude = $wrapLongitude;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $data = [];
        if ($this->getField()) {
            $data['field'] = $this->getField();
        } else {
            throw new \LogicException('Geo bounds aggregation must have a field set.');
        }

        $data['wrap_longitude'] = $this->isWrapLongitude();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'geo_bounds';
    }
}
