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
 * Represents Elasticsearch "geo_distance" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-distance-query.html
 */
class GeoDistanceQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private string $field,
        private string $distance,
        private mixed $location,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'geo_distance';
    }

    public function toArray(): array
    {
        $query = [
            'distance' => $this->distance,
            $this->field => $this->location,
        ];
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
