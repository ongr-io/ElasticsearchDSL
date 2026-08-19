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
 * Represents Elasticsearch "geo_polygon" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-polygon-query.html
 */
class GeoPolygonQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private string $field,
        private array $points = [],
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'geo_polygon';
    }

    public function toArray(): array
    {
        $query = [$this->field => ['points' => $this->points]];
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
