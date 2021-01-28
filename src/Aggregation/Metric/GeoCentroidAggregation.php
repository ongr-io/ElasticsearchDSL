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

    public function __construct(string $name, ?string $field = null)
    {
        parent::__construct($name);

        $this->setField($field);
    }

    public function getArray(): array
    {
        $data = [];

        if ($this->getField()) {
            $data['field'] = $this->getField();

            return $data;
        }

        throw new \LogicException('Geo centroid aggregation must have a field set.');
    }

    public function getType(): string
    {
        return 'geo_centroid';
    }
}
