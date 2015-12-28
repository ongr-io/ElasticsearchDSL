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
    'The HasParentFilter class is deprecated and will be removed in 2.0. Use HasParentQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\DslTypeAwareTrait;
use ONGR\ElasticsearchDSL\Query\HasParentQuery;

/**
 * Elasticsearch has_parent filter.
 *
 * @deprecated Will be removed in 2.0. Use the HasParentQuery instead.
 */
class HasParentFilter extends HasParentQuery
{
    use DslTypeAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct($type, BuilderInterface $query, array $parameters = [])
    {
        $this->setDslType('filter');

        parent::__construct($type, $query, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $result = parent::toArray();

        if ($this->getDslType() !== 'query') {
            $result[$this->getDslType()] = $result['query'];
            unset($result['query']);
        }

        return $result;
    }
}
