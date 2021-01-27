<?php

declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;

/**
 * Class representing RangeAggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-range-aggregation.html
 */
class RangeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    public function __construct(
        private string $name,
        private ?string $field = null,
        private array $ranges = [],
        private bool $keyed = false
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setKeyed($keyed);
        foreach ($ranges as $range) {
            $from = isset($range['from']) ? $range['from'] : null;
            $to = isset($range['to']) ? $range['to'] : null;
            $key = isset($range['key']) ? $range['key'] : null;
            $this->addRange($from, $to, $key);
        }
    }

    public function setKeyed(bool $keyed): static
    {
        $this->keyed = $keyed;

        return $this;
    }

    public function addRange(mixed $from = null, mixed $to = null, string $key = ''): static
    {
        $range = array_filter(
            [
                'from' => $from,
                'to' => $to,
            ]
        );

        if (!empty($key)) {
            $range['key'] = $key;
        }

        $this->ranges[] = $range;

        return $this;
    }

    public function removeRange(int|float|null $from, int|float|null $to): bool
    {
        foreach ($this->ranges as $key => $range) {
            if (array_diff_assoc(array_filter(['from' => $from, 'to' => $to]), $range) === []) {
                unset($this->ranges[$key]);

                return true;
            }
        }

        return false;
    }

    public function removeRangeByKey(string $key): bool
    {
        if ($this->keyed) {
            foreach ($this->ranges as $rangeKey => $range) {
                if (array_key_exists('key', $range) && $range['key'] === $key) {
                    unset($this->ranges[$rangeKey]);

                    return true;
                }
            }
        }

        return false;
    }

    public function getArray(): array
    {
        $data = [
            'keyed' => $this->keyed,
            'ranges' => array_values($this->ranges),
        ];

        if ($this->getField()) {
            $data['field'] = $this->getField();
        }

        return $data;
    }

    public function getType(): string
    {
        return 'range';
    }
}
