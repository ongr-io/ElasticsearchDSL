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
 * Class representing date range aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-daterange-aggregation.html
 */
class DateRangeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    private array $ranges = [];

    private bool $keyed = false;

    public function __construct(
        private string $name,
        private ?string $field = null,
        private ?string $format = null,
        array $ranges = [],
        bool $keyed = false
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setFormat($format);
        $this->setKeyed($keyed);
        foreach ($ranges as $range) {
            $from = isset($range['from']) ? $range['from'] : null;
            $to = isset($range['to']) ? $range['to'] : null;
            $key = isset($range['key']) ? $range['key'] : null;
            $this->addRange($from, $to, $key);
        }
    }

    public function setKeyed($keyed): static
    {
        $this->keyed = $keyed;

        return $this;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function setFormat($format): static
    {
        $this->format = $format;

        return $this;
    }

    public function addRange(?string $from = null, ?string $to = null, ?string $key = null): static
    {
        $range = array_filter(
            [
                'from' => $from,
                'to' => $to,
                'key' => $key,
            ],
            fn(mixed $v): bool => !is_null($v)
        );

        if (empty($range)) {
            throw new \LogicException('Either from or to must be set. Both cannot be null.');
        }

        $this->ranges[] = $range;

        return $this;
    }

    public function getArray(): array
    {
        if (!$this->getField() || !$this->getFormat() || empty($this->ranges)) {
            throw new \LogicException('Date range aggregation must have field, format set and range added.');
        }

        return [
            'format' => $this->getFormat(),
            'field' => $this->getField(),
            'ranges' => $this->ranges,
            'keyed' => $this->keyed,
        ];
    }

    public function getType(): string
    {
        return 'date_range';
    }
}
