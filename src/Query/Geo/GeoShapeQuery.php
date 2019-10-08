<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query\Geo;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "geo_shape" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-shape-query.html
 */
class GeoShapeQuery implements BuilderInterface
{
    use ParametersTrait;

    const INTERSECTS = 'intersects';
    const DISJOINT = 'disjoint';
    const WITHIN = 'within';
    const CONTAINS = 'contains';

    /**
     * @var array
     */
    private $fields = [];

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'geo_shape';
    }

    /**
     * Add geo-shape provided filter.
     *
     * @param string $field       Field name.
     * @param string $type        Shape type.
     * @param array  $coordinates Shape coordinates.
     * @param string $relation    Spatial relation.
     * @param array  $parameters  Additional parameters.
     */
    public function addShape($field, $type, array $coordinates, $relation = self::INTERSECTS, array $parameters = [])
    {
        // TODO: remove this in the next major version
        if (is_array($relation)) {
            $parameters = $relation;
            $relation = self::INTERSECTS;
            trigger_error('$parameters as parameter 4 in addShape is deprecated', E_USER_DEPRECATED);
        }

        $filter = array_merge(
            $parameters,
            [
                'type' => $type,
                'coordinates' => $coordinates,
            ]
        );

        $this->fields[$field] = [
            'shape' => $filter,
            'relation' => $relation,
        ];
    }

    /**
     * Add geo-shape pre-indexed filter.
     *
     * @param string $field      Field name.
     * @param string $id         The ID of the document that containing the pre-indexed shape.
     * @param string $type       Name of the index where the pre-indexed shape is.
     * @param string $index      Index type where the pre-indexed shape is.
     * @param string $relation   Spatial relation.
     * @param string $path       The field specified as path containing the pre-indexed shape.
     * @param array  $parameters Additional parameters.
     */
    public function addPreIndexedShape(
        $field,
        $id,
        $type,
        $index,
        $path,
        $relation = self::INTERSECTS,
        array $parameters = []
    ) {
        // TODO: remove this in the next major version
        if (is_array($relation)) {
            $parameters = $relation;
            $relation = self::INTERSECTS;
            trigger_error('$parameters as parameter 6 in addShape is deprecated', E_USER_DEPRECATED);
        }

        $filter = array_merge(
            $parameters,
            [
                'id' => $id,
                'type' => $type,
                'index' => $index,
                'path' => $path,
            ]
        );

        $this->fields[$field] = [
            'indexed_shape' => $filter,
            'relation' => $relation,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = $this->processArray($this->fields);

        return [$this->getType() => $output];
    }
}
