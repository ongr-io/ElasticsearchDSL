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
    'The IdsFilter class is deprecated and will be removed in 2.0. Use IdsQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\Query\IdsQuery;

/**
 * Represents Elasticsearch "ids" filter.
 *
 * @deprecated Will be removed in 2.0. Use the IdsQuery instead.
 */
class IdsFilter extends IdsQuery
{
}
