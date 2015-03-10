<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Query;

use ONGR\ElasticsearchBundle\DSL\Bool\Bool;
use ONGR\ElasticsearchBundle\DSL\BuilderInterface;

/**
 * Provides query container functionality to any class.
 */
trait QueryAwareTrait
{
    /**
     * @var BuilderInterface[]
     */
    private $queries = [];

    /**
     * @var \ONGR\ElasticsearchBundle\DSL\Bool\Bool
     */
    private $boolQuery;

    /**
     * @param BuilderInterface $query
     * @param string           $boolType
     *
     * @return $this
     */
    public function addQuery(BuilderInterface $query, $boolType = Bool::MUST)
    {
        if ($boolType !== Bool::MUST || $this->boolQuery !== null) {
            $this->getBoolQuery()->addToBool($query, $boolType);
        } else {
            $this->queries[$query->getType()] = $query;
        }

        return $this;
    }

    /**
     * Returns Bool query. Creates new instance if there is not initiated.
     *
     * @return \ONGR\ElasticsearchBundle\DSL\Bool\Bool
     */
    public function getBoolQuery()
    {
        if (!$this->boolQuery) {
            $this->boolQuery = new Bool();
        }

        return $this->boolQuery;
    }

    /**
     * @param array $params Example values:
     *                      - minimum_should_match => 1
     *                      - boost => 1.
     */
    public function setBoolQueryParameters(array $params)
    {
        $this->getBoolQuery()->setParameters($params);
    }

    /**
     * Checks if there is added specific query.
     *
     * @param string $key
     * @param string $boolType
     *
     * @return bool
     */
    public function hasQuery($key, $boolType = Bool::MUST)
    {
        return array_key_exists($key, $this->queries[$boolType]);
    }

    /**
     * Removes specific query.
     *
     * @param string $key
     */
    public function removeQuery($key)
    {
        if ($this->hasQuery($key)) {
            unset($this->queries[$key]);
        }
    }

    /**
     * Completely resets query.
     */
    public function destroyQuery()
    {
        $this->queries = [];
        $this->boolQuery = null;
    }

    /**
     * Return all queries.
     *
     * @return array
     */
    public function getQueries()
    {
        return $this->queries;
    }

    /**
     * Aggregates all queries to array.
     *
     * @return array
     */
    public function processQueries()
    {
        if ($this->boolQuery || count($this->getQueries()) > 1) {
            $bool = $this->getBoolQuery();
            foreach ($this->getQueries() as $query) {
                $bool->addToBool($query);
            }

            return ['query' => [$bool->getType() => $bool->toArray()]];
        } elseif (count($this->getQueries()) == 1) {
            $query = array_values($this->getQueries())[0];

            return ['query' => [$query->getType() => $query->toArray()]];
        }

        return [];
    }
}
