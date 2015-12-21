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
    'The BoolFilter class is deprecated and will be removed in 2.0. Use BoolQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\Query\BoolQuery;

/**
 * Represents Elasticsearch "bool" filter.
 *
 * @link http://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-filter.html
 *
 * @deprecated Will be removed in 2.0. Use the BoolQuery instead.
 */
class BoolFilter extends BoolQuery
{
}
