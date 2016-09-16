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
 * Class representing geo centroid aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-geocentroid-aggregation.html
 */
class GeoCentroidAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     */
    public function __construct($name, $field = null)
    {
        parent::__construct($name);

        $this->setField($field);
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
            throw new \LogicException('Geo centroid aggregation must have a field set.');
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'geo_centroid';
    }
}
