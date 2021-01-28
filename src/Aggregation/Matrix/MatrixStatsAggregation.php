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

namespace ONGR\ElasticsearchDSL\Aggregation\Matrix;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;

/**
 * Class representing Max Aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-max-aggregation.html
 */
class MatrixStatsAggregation extends AbstractAggregation
{
    use MetricTrait;

    public function __construct(
        private string $name,
        private string|array $field,
        private ?array $missing = null,
        private ?string $mode = null
    ) {
        parent::__construct($name);

        $this->setField($field);
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function setMode(?string $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    public function getMissing(): ?array
    {
        return $this->missing;
    }

    public function setMissing(?array $missing): static
    {
        $this->missing = $missing;

        return $this;
    }

    public function getType(): string
    {
        return 'matrix_stats';
    }

    protected function getArray(): array
    {
        $out = [];
        if ($this->getField()) {
            $out['fields'] = $this->getField();
        }

        if ($this->getMode()) {
            $out['mode'] = $this->getMode();
        }


        if ($this->getMissing()) {
            $out['missing'] = $this->getMissing();
        }

        return $out;
    }
}
