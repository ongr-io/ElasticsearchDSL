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

namespace ONGR\ElasticsearchDSL\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;

/**
 * Class representing geo distance aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-geodistance-aggregation.html
 */
class GeoDistanceAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * Inner aggregations container init.
     */
    public function __construct(
        protected string $name,
        protected ?string $field = null,
        protected ?string $origin = null,
        protected array $ranges = [],
        protected ?string $unit = null,
        protected ?string $distanceType = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setOrigin($origin);
        foreach ($ranges as $range) {
            $from = isset($range['from']) ? $range['from'] : null;
            $to = isset($range['to']) ? $range['to'] : null;
            $this->addRange($from, $to);
        }
        $this->setUnit($unit);
        $this->setDistanceType($distanceType);
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getDistanceType(): ?string
    {
        return $this->distanceType;
    }

    public function setDistanceType(?string $distanceType): static
    {
        $this->distanceType = $distanceType;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Add range to aggregation.
     */
    public function addRange(null|int|float|string $from = null, null|int|float|string $to = null): static
    {
        $range = array_filter(
            [
                'from' => $from,
                'to' => $to,
            ]
        );

        if (empty($range)) {
            throw new \LogicException('Either from or to must be set. Both cannot be null.');
        }

        $this->ranges[] = $range;

        return $this;
    }

    public function getArray(): array
    {
        $data = [];

        if ($this->getField()) {
            $data['field'] = $this->getField();
        } else {
            throw new \LogicException('Geo distance aggregation must have a field set.');
        }

        if ($this->getOrigin()) {
            $data['origin'] = $this->getOrigin();
        } else {
            throw new \LogicException('Geo distance aggregation must have an origin set.');
        }

        if ($this->getUnit()) {
            $data['unit'] = $this->getUnit();
        }

        if ($this->getDistanceType()) {
            $data['distance_type'] = $this->getDistanceType();
        }

        $data['ranges'] = $this->ranges;

        return $data;
    }

    public function getType(): string
    {
        return 'geo_distance';
    }
}
