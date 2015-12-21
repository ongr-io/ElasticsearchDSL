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
    'The NestedFilter class is deprecated and will be removed in 2.0. Use NestedQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\Query\NestedQuery;

/**
 * Nested filter implementation.
 *
 * @deprecated Will be removed in 2.0. Use the NestedQuery instead.
 */
class NestedFilter extends NestedQuery
{
    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $result = parent::toArray();
        $result['filter'] = $result['query'];
        unset($result['query']);

        return $result;
    }
}
