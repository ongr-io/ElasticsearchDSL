<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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

    public const INTERSECTS = 'intersects';

    public const DISJOINT = 'disjoint';

    public const WITHIN = 'within';

    public const CONTAINS = 'contains';

    private array $fields = [];

    public function __construct(array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'geo_shape';
    }

    public function addShape(
        string $field,
        string $type,
        array $coordinates,
        string $relation = self::INTERSECTS,
        array $parameters = []
    ): void {
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

    public function addPreIndexedShape(
        string $field,
        string $id,
        string $type,
        string $index,
        string $path,
        string $relation = self::INTERSECTS,
        array $parameters = []
    ): void {
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

    public function toArray(): array
    {
        $output = $this->processArray($this->fields);

        return [$this->getType() => $output];
    }
}
