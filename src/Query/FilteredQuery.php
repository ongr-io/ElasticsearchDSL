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

use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Represents Elasticsearch "filtered" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-filtered-query.html
 */
class FilteredQuery implements BuilderInterface
{
    /**
     * @var BuilderInterface
     */
    private $query;

    /**
     * @var BuilderInterface
     */
    private $filter;

    /**
     * @var array
     */
    private $boolFilter;

    /**
     * @param BuilderInterface $query
     * @param BuilderInterface $filter
     */
    public function __construct(BuilderInterface $query = null, BuilderInterface $filter = null)
    {
        $this->query = $query;
        $this->filter = $filter;
    }

    /**
     * adds a query to join with AND operator
     *
     * @param BuilderInterface $must
     * @param BuilderInterface $should
     * @param BuilderInterface $mustNot
     */
    public function addBoolFilter(
        BuilderInterface $must = null,
        BuilderInterface $should = null,
        BuilderInterface $mustNot = null
    )
    {
        if (!$must && !$should && !$mustNot) {
            return;
        }
        $filter = [];
        if ($must) {
            $filter['bool']['must'] = $must->toArray();
        }
        if ($should) {
            $filter['bool']['should'] = $should->toArray();
        }
        if ($mustNot) {
            $filter['bool']['should'] = $should->toArray();
        }

        $this->boolFilter = $filter;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'filtered';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = [];

        if (isset($this->query)) {
            $output['query'] = $this->query->toArray();
        }
        if (isset($this->filter) || isset($this->boolFilter)) {
            $output['filter'] = isset($this->filter) ? $this->filter->toArray() : $this->boolFilter;
        }

        return [$this->getType() => $output];
    }
}
