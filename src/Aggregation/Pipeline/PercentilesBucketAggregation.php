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

/**
 * Class representing Percentiles Bucket Pipeline Aggregation.
 *
 * @link https://goo.gl/bqi7m5
 */
class PercentilesBucketAggregation extends AbstractPipelineAggregation
{
    private array $percents;

    public function getType(): string
    {
        return 'percentiles_bucket';
    }

    public function getPercents(): array
    {
        return $this->percents;
    }

    public function setPercents(array $percents): static
    {
        $this->percents = $percents;

        return $this;
    }

    public function getArray(): array
    {
        $data = ['buckets_path' => $this->getBucketsPath()];

        if ($this->getPercents()) {
            $data['percents'] = $this->getPercents();
        }

        return $data;
    }
}
