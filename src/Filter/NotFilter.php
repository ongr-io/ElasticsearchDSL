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
 * Represents Elasticsearch "not" filter.
 *
 * @link http://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-not-filter.html
 */
class NotFilter implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var BuilderInterface
     */
    private $filter;

    /**
     * @param BuilderInterface $filter     Filter.
     * @param array            $parameters Optional parameters.
     */
    public function __construct(BuilderInterface $filter = null, array $parameters = [])
    {
        if ($filter !== null) {
            $this->setFilter($filter);
        }
        $this->setParameters($parameters);
    }
    
    /**
     * Returns filter.
     *
     * @return BuilderInterface
     */
    public function getFilter()
    {
        return $this->filter;
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
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'not';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [];
        $query['filter'] = [$this->filter->getType() => $this->filter->toArray()];

        $output = $this->processArray($query);

        return $output;
    }
}
