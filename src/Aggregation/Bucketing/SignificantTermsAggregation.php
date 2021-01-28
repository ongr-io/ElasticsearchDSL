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

namespace ONGR\ElasticsearchDSL\Aggregation\Bucketing;

/**
 * Class representing TermsAggregation.
 *
 * @link https://goo.gl/xI7zoa
 */
class SignificantTermsAggregation extends TermsAggregation
{
    public function getType(): string
    {
        return 'significant_terms';
    }
}
