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
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "bool" filter.
 *
 * @link http://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-filtered-query.html
 */
class FilteredQuery implements BuilderInterface
{
    use ParametersTrait;
    
    /**
     * @var BuilderInterface Used query inside filtered query.
     */
    private $query;

    /**
     * @var BuilderInterface Used filter inside filtered query.
     */
    private $filter;

    /**
     * @param BuilderInterface $query
     * @param BuilderInterface $filter
     */
    public function __construct($query = null, $filter = null)
    {
        if ($query !== null) {
            $this->setQuery($query);
        }
        
        if ($filter !== null) {
            $this->setFilter($filter);
        }
    }

    /**
     * Sets query.
     *
     * @param BuilderInterface $query
     */
    public function setQuery(BuilderInterface $query)
    {
        $this->query = $query;
    }

    /**
     * @return BuilderInterface
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Sets filter.
     *
     * @param BuilderInterface $filter
     */
    public function setFilter(BuilderInterface $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return BuilderInterface
     */
    public function getFilter()
    {
        return $this->filter;
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
        
        if ($this->getFilter()) {
            $output['filter'][$this->getFilter()->getType()] = $this->getFilter()->toArray();
        }

        if ($this->getQuery()) {
            $output['query'][$this->getQuery()->getType()] = $this->getQuery()->toArray();
        }

        return count($output) > 0 ? $this->processArray($output) : [];
    }
}
