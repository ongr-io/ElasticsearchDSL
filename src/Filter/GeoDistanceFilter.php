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
    'The GeoDistanceFilter class is deprecated and will be removed in 2.0. Use GeoDistanceQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\Query\GeoDistanceQuery;

/**
 * Represents Elasticsearch "Geo Distance Filter" filter.
 *
 * @deprecated Will be removed in 2.0. Use the GeoDistanceQuery instead.
 */
class GeoDistanceFilter extends GeoDistanceQuery
{
}
