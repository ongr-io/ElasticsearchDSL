<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Bool;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Query\BoolQuery;

/**
 * Bool operator. Can be used for filters and queries.
 *
 * @deprecated Will be removed in 1.0. Use ONGR\ElasticsearchDSL\Query\BoolQuery.
 */
class Bool extends BoolQuery
{
    /**
     * Add BuilderInterface object to bool operator.
     *
     * @param BuilderInterface $bool
     * @param string           $type
     *
     * @throws \UnexpectedValueException
     *
     * @deprecated Will be removed in 1.0. Use ONGR\ElasticsearchDSL\Query\BoolQuery::add().
     */
    public function addToBool(BuilderInterface $bool, $type = BoolQuery::MUST)
    {
        $this->add($bool, $type);
    }
}
