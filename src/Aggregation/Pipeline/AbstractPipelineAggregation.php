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
