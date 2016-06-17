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
 * Elasticsearch span containing query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-containing-query.html
 */
class SpanContainingQuery implements SpanQueryInterface
{
    /**
     * @param SpanQueryInterface
     */
    private $big;

    /**
     * @param SpanQueryInterface
     */
    private $little;

    /**
     * @param SpanQueryInterface $big
     * @param SpanQueryInterface $little
     */
    public function __construct(SpanQueryInterface $big, SpanQueryInterface $little)
    {
        $this->big = $big;
        $this->little = $little;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'span_containing';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $out = [
            'little' => $this->little->toArray(),
            'big' => $this->big->toArray(),
        ];

        return [$this->getType() => $out];
    }
}
