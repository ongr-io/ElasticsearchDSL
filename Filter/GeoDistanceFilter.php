<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Filter;

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;
use ONGR\ElasticsearchBundle\DSL\ParametersTrait;

/**
 * Represents Elasticsearch "Geo Distance Filter" filter.
 */
class GeoDistanceFilter implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $distance;

    /**
     * @var string
     */
    private $field;

    /**
     * @var mixed
     */
    private $location;

    /**
     * @param string $distance
     * @param string $field
     * @param mixed  $location
     * @param array  $parameters
     */
    public function __construct($distance, $field, $location, array $parameters = [])
    {
        $this->distance = $distance;
        $this->field = $field;
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
