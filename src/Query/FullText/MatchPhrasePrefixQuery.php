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
 * Represents Elasticsearch "match_phrase_prefix" query.
 *
 * @author Ron Rademaker
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
 */
class MatchPhrasePrefixQuery extends MatchQuery
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'match_phrase_prefix';
    }
}
