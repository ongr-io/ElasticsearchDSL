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
    'The PrefixFilter class is deprecated and will be removed in 2.0. Use PrefixQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\Query\PrefixQuery;

/**
 * Represents Elasticsearch "prefix" filter.
 *
 * Filters documents that have fields containing terms with a specified prefix.
 *
 * @deprecated Will be removed in 2.0. Use the PrefixQuery instead.
 */
class PrefixFilter extends PrefixQuery
{
    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [$this->field => $this->value];

        $output = $this->processArray($query);

        return $output;
    }
}
