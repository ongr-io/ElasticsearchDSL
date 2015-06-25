<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Filter;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Elasticsearch geo polygon filter.
 */
class GeoPolygonFilter implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $field;

    /**
     * @var array
     */
    private $points;

    /**
     * @param string $field
     * @param array  $points
     * @param array  $parameters
     */
    public function __construct($field, array $points = [], array $parameters = [])
    {
        $this->field = $field;
        $this->points = $points;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'geo_polygon';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [];
        $query[$this->field] = ['points' => $this->points];
        $output = $this->processArray($query);

        return $output;
    }
}
