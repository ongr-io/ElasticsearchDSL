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
 * Class representing Histogram aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-histogram-aggregation.html
 */
class HistogramAggregation extends AbstractAggregation
{
    use BucketingTrait;

    public const DIRECTION_ASC = 'asc';

    public const DIRECTION_DESC = 'desc';

    protected array $extendedBounds = [];

    protected ?bool $keyed = null;

    public function __construct(
        private string $name,
        private ?string $field = null,
        private ?int $interval = null,
        private ?int $minDocCount = null,
        private ?string $orderMode = null,
        private string $orderDirection = self::DIRECTION_ASC,
        ?int $extendedBoundsMin = null,
        ?int $extendedBoundsMax = null,
        ?bool $keyed = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setExtendedBounds($extendedBoundsMin, $extendedBoundsMax);
        $this->setKeyed($keyed);
    }

    public function isKeyed(): ?bool
    {
        return $this->keyed;
    }

    public function setKeyed(?bool $keyed): static
    {
        $this->keyed = $keyed;

        return $this;
    }

    public function setOrder(?string $mode, string $direction = self::DIRECTION_ASC): static
    {
        $this->orderMode = $mode;
        $this->orderDirection = $direction;

        return $this;
    }

    public function getOrder(): ?array
    {
        if ($this->orderMode && $this->orderDirection) {
            return [$this->orderMode => $this->orderDirection];
        }

        return null;
    }

    public function getInterval(): int
    {
        return $this->interval;
    }

    public function setInterval(?int $interval): static
    {
        $this->interval = $interval;

        return $this;
    }

    public function getMinDocCount(): ?int
    {
        return $this->minDocCount;
    }

    public function setMinDocCount(?int $minDocCount): static
    {
        $this->minDocCount = $minDocCount;

        return $this;
    }

    public function getExtendedBounds(): array
    {
        return $this->extendedBounds;
    }

    public function setExtendedBounds(?int $min = null, ?int $max = null): static
    {
        $bounds = array_filter(
            [
                'min' => $min,
                'max' => $max,
            ],
            'strlen'
        );
        $this->extendedBounds = $bounds;

        return $this;
    }

    public function getType(): string
    {
        return 'histogram';
    }

    public function getArray(): array
    {
        $out = array_filter(
            [
                'field' => $this->getField(),
                'interval' => $this->getInterval(),
                'min_doc_count' => $this->getMinDocCount(),
                'extended_bounds' => $this->getExtendedBounds(),
                'keyed' => $this->isKeyed(),
                'order' => $this->getOrder(),
            ],
            fn(mixed $val): bool => ($val || is_numeric($val))
        );
        $this->checkRequiredParameters($out, ['field', 'interval']);

        return $out;
    }

    protected function checkRequiredParameters(array $data, array $required): void
    {
        if (count(array_intersect_key(array_flip($required), $data)) !== count($required)) {
            throw new \LogicException('Histogram aggregation must have field and interval set.');
        }
    }
}
