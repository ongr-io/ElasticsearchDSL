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
 * Class representing Serial Differencing Pipeline Aggregation.
 *
 * @link https://goo.gl/46ZR4v
 */
class SerialDifferencingAggregation extends AbstractPipelineAggregation
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'serial_diff';
    }
}
