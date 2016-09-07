<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * Class representing Max Bucket Pipeline Aggregation.
 *
 * @link http://goo.gl/x2HMHY
 */
class PercentilesBucketAggregation extends AbstractPipelineAggregation
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'percentiles_bucket';
    }
}
