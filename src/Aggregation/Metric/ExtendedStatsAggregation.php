<?php

namespace ONGR\ElasticsearchDSL\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;
use ONGR\ElasticsearchDSL\ScriptAwareTrait;

/**
 * Class representing Extended stats aggregation.
 *
 * @link http://goo.gl/E0PpDv
 */
class ExtendedStatsAggregation extends AbstractAggregation
{
    use MetricTrait;

    use ScriptAwareTrait;

    public function __construct(
        private string $name,
        private ?string $field = null,
        private ?int $sigma = null,
        private ?string $script = null
    ) {
        parent::__construct($name);

        $this->setField($field);
    }

    public function getSigma(): ?int
    {
        return $this->sigma;
    }

    public function setSigma(?int $sigma): static
    {
        $this->sigma = $sigma;

        return $this;
    }

    public function getType(): string
    {
        return 'extended_stats';
    }

    public function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
                'sigma' => $this->getSigma(),
            ],
            fn(mixed $val): bool => $val || is_numeric($val)
        );
    }
}
