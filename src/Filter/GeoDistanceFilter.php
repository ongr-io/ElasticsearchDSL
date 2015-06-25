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
 * Represents Elasticsearch "Geo Distance Filter" filter.
 */
class GeoDistanceFilter implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $distance;

    /**
     * @var mixed
     */
    private $location;

    /**
     * @param string $field
     * @param string $distance
     * @param mixed  $location
     * @param array  $parameters
     */
    public function __construct($field, $distance, $location, array $parameters = [])
    {
        $this->field = $field;
        $this->distance = $distance;
        $this->location = $location;

        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'geo_distance';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            'distance' => $this->distance,
            $this->field => $this->location,
        ];
        $output = $this->processArray($query);

        return $output;
    }
}
