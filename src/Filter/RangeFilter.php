<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Filter;

@trigger_error(
    'The RangeFilter class is deprecated and will be removed in 2.0. Use RangeQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\Query\RangeQuery;

/**
 * Represents Elasticsearch "range" filter.
 *
 * Filters documents with fields that have terms within a certain range.
 *
 * @deprecated Will be removed in 2.0. Use the RangeQuery instead.
 */
class RangeFilter extends RangeQuery
{
    /**
     * @param string $field      Field name.
     * @param array  $range      Range values.
     * @param array  $parameters Optional parameters.
     */
    public function __construct($field, $range, array $parameters = [])
    {
        parent::__construct($field, array_merge($range, $parameters));
    }
}
