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
    'The GeohashCellFilter class is deprecated and will be removed in 2.0. Use GeohashCellQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\Query\GeohashCellQuery;

/**
 * Represents Elasticsearch "Geohash Cell" filter.
 *
 * @deprecated Will be removed in 2.0. Use the GeohashCellQuery instead.
 */
class GeohashCellFilter extends GeohashCellQuery
{
}
