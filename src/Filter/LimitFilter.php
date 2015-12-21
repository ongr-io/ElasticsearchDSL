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
    'The LimitFilter class is deprecated and will be removed in 2.0. Use LimitQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\Query\LimitQuery;

/**
 * Represents Elasticsearch "limit" filter.
 *
 * A limit filter limits the number of documents (per shard) to execute on.
 *
 * @deprecated Will be removed in 2.0. Use the LimitQuery instead.
 */
class LimitFilter extends LimitQuery
{
}
