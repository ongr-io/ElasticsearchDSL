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
 * Class representing Avg Bucket Pipeline Aggregation.
 *
 * @link https://goo.gl/SWK2nP
 */
class AvgBucketAggregation extends AbstractPipelineAggregation
{
    public function getType(): string
    {
        return 'avg_bucket';
    }
}
