<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Bucketing;

/**
 * Class representing TermsAggregation.
 *
 * @link https://goo.gl/xI7zoa
 */
class SignificantTextAggregation extends TermsAggregation
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'significant_text';
    }
}
