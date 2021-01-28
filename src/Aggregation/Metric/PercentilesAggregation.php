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
 * Class representing PercentilesAggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-percentile-aggregation.html
 */
class PercentilesAggregation extends AbstractAggregation
{
    use MetricTrait;

    use ScriptAwareTrait;

    private ?int $compression = null;

    public function __construct(
        private string $name,
        private ?string $field = null,
        private ?array $percents = null,
        ?string $script = null,
        ?int $compression = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setPercents($percents);
        $this->setScript($script);
        $this->setCompression($compression);
    }

    public function getPercents(): ?array
    {
        return $this->percents;
    }

    public function setPercents(?array $percents): static
    {
        $this->percents = $percents;

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
        return 'percentiles';
    }

    public function getArray(): array
    {
        $out = array_filter(
            [
                'compression' => $this->getCompression(),
                'percents' => $this->getPercents(),
                'field' => $this->getField(),
                'script' => $this->getScript(),
            ],
            fn(mixed $val): bool => $val || is_numeric($val)
        );

        $this->isRequiredParametersSet($out);

        return $out;
    }

    private function isRequiredParametersSet(array $a): void
    {
        if (!array_key_exists('field', $a) && !array_key_exists('script', $a)) {
            throw new \LogicException('Percentiles aggregation must have field or script set.');
        }
    }
}
