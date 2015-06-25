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

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "and" filter.
 *
 * @link http://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-and-filter.html
 */
class AndFilter implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var array
     */
    private $filters = [];
    
    /**
     * @param BuilderInterface[] $filters    Filter array.
     * @param array              $parameters Optional parameters.
     */
    public function __construct(array $filters = [], array $parameters = [])
    {
        $this->set($filters);
        $this->setParameters($parameters);
    }

    /**
     * Sets filters.
     *
     * @param BuilderInterface[] $filters Filter array.
     */
    public function set(array $filters)
    {
        foreach ($filters as $filter) {
            $this->add($filter);
        }
    }
    
    /**
     * Adds filter.
     *
     * @param BuilderInterface $filter
     *
     * @return AndFilter
     */
    public function add(BuilderInterface $filter)
    {
        $this->filters[] = [$filter->getType() => $filter->toArray()];
        
        return $this;
    }

    /**
     * Clears filters.
     */
    public function clear()
    {
        $this->filters = [];
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = $this->processArray();

        if (count($query) > 0) {
            $query['filters'] = $this->filters;
        } else {
            $query = $this->filters;
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'and';
    }
}
