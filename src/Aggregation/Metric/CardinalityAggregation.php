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
 * Difference values counter.
 *
 * @link http://goo.gl/tG7ciG
 */
class CardinalityAggregation extends AbstractAggregation
{
    use MetricTrait;

    use ScriptAwareTrait;

    private ?int $precisionThreshold = null;

    private ?bool $rehash = null;

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        $out = array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
                'precision_threshold' => $this->getPrecisionThreshold(),
                'rehash' => $this->isRehash(),
            ],
            fn(mixed $val): bool => $val || is_bool($val)
        );

        $this->checkRequiredFields($out);

        return $out;
    }

    public function setPrecisionThreshold(?int $precision): static
    {
        $this->precisionThreshold = $precision;

        return $this;
    }

    public function getPrecisionThreshold(): ?int
    {
        return $this->precisionThreshold;
    }

    public function isRehash(): ?bool
    {
        return $this->rehash;
    }

    public function setRehash(?bool $rehash): static
    {
        $this->rehash = $rehash;

        return $this;
    }

    public function getType(): string
    {
        return 'cardinality';
    }

    private function checkRequiredFields(array $fields): void
    {
        if (!array_key_exists('field', $fields) && !array_key_exists('script', $fields)) {
            throw new \LogicException('Cardinality aggregation must have field or script set.');
        }
    }
}
