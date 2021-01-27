<?php

declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Aggregation\Pipeline;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;

abstract class AbstractPipelineAggregation extends AbstractAggregation
{
    use MetricTrait;

    public function __construct(private string $name, private mixed $bucketsPath)
    {
        parent::__construct($name);
        $this->setBucketsPath($bucketsPath);
    }

    public function getBucketsPath(): mixed
    {
        return $this->bucketsPath;
    }

    public function setBucketsPath(mixed $bucketsPath): static
    {
        $this->bucketsPath = $bucketsPath;

        return $this;
    }

    public function getArray(): array
    {
        return ['buckets_path' => $this->getBucketsPath()];
    }
}
