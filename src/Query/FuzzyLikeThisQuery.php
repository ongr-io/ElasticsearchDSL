<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query;

/**
 * Elasticsearch fuzzy_like_this query class.
 */
class FuzzyLikeThisQuery extends FuzzyLikeThisFieldQuery
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'fuzzy_like_this';
    }
}
