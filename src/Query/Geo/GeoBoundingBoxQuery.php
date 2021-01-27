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
 * Represents Elasticsearch "geo_bounding_box" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-bounding-box-query.html
 */
class GeoBoundingBoxQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private string $field,
        private array $values,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'geo_bounding_box';
    }

    public function toArray(): array
    {
        return [
            $this->getType() => $this->processArray([$this->field => $this->points()])
        ];
    }

    private function points(): array
    {
        if (count($this->values) === 2) {
            return [
                'top_left' => $this->values[0] ?? $this->values['top_left'],
                'bottom_right' => $this->values[1] ?? $this->values['bottom_right'],
            ];
        } elseif (count($this->values) === 4) {
            return [
                'top' => $this->values[0] ?? $this->values['top'],
                'left' => $this->values[1] ?? $this->values['left'],
                'bottom' => $this->values[2] ?? $this->values['bottom'],
                'right' => $this->values[3] ?? $this->values['right'],
            ];
        }

        throw new \LogicException('Geo Bounding Box filter must have 2 or 4 geo points set.');
    }
}
