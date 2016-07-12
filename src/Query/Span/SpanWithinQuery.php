<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query\Span;

/**
 * Elasticsearch span within query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-within-query.html
 */
class SpanWithinQuery extends SpanContainingQuery
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'span_within';
    }
}
