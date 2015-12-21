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
    'The TermsFilter class is deprecated and will be removed in 2.0. Use TermsQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\Query\TermsQuery;

/**
 * Represents Elasticsearch "terms" filter.
 *
 * @deprecated Will be removed in 2.0. Use the TermsQuery instead.
 */
class TermsFilter extends TermsQuery
{
}
