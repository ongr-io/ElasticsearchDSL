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
use ONGR\ElasticsearchDSL\ScriptAwareTrait;

/**
 * Class representing Percentile Ranks Aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-percentile-rank-aggregation.html
 */
class PercentileRanksAggregation extends AbstractAggregation
{
    use MetricTrait;

    use ScriptAwareTrait;

    public function __construct(
        private string $name,
        private ?string $field = null,
        private ?array $values = null,
        ?string $script = null,
        ?int $compression = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setValues($values);
        $this->setScript($script);
        $this->setCompression($compression);
    }

    public function getValues(): ?array
    {
        return $this->values;
    }

    public function setValues(?array $values): static
    {
        $this->values = $values;

        return $this;
    }

    public function getCompression(): ?int
    {
        return $this->compression;
    }

    public function setCompression(?int $compression): static
    {
        $this->compression = $compression;

        return $this;
    }

    public function getType(): string
    {
        return 'percentile_ranks';
    }

    public function getArray(): array
    {
        $out = array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
                'values' => $this->getValues(),
                'compression' => $this->getCompression(),
            ],
            fn(mixed $val): bool => $val || is_numeric($val)
        );

        $this->isRequiredParametersSet($out);

        return $out;
    }

    private function isRequiredParametersSet(array $a): void
    {
        if (array_key_exists('field', $a) && array_key_exists('values', $a)
            || (array_key_exists('script', $a) && array_key_exists('values', $a))
        ) {
            return;
        }
        throw new \LogicException('Percentile ranks aggregation must have field and values or script and values set.');
    }
}
