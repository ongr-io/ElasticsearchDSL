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
    'The MatchAllFilter class is deprecated and will be removed in 2.0. Use MatchAllQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\Query\MatchAllQuery;

/**
 * Represents Elasticsearch "match_all" filter.
 *
 * A filter matches on all documents.
 *
 * @deprecated Will be removed in 2.0. Use the MatchAllQuery instead.
 */
class MatchAllFilter extends MatchAllQuery
{
}
