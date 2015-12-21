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
    'The ExistsFilter class is deprecated and will be removed in 2.0. Use ExistsQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\Query\ExistsQuery;

/**
 * Represents Elasticsearch "exists" filter.
 *
 * @link http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-exists-filter.html
 *
 * @deprecated Will be removed in 2.0. Use the ExistsQuery instead.
 */
class ExistsFilter extends ExistsQuery
{
}
