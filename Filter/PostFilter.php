<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Filter;

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;

/**
 * Represents Elasticsearch "post_filter" filter.
 *
 * @link http://www.elastic.co/guide/en/elasticsearch/guide/current/_post_filter.html
 */
class PostFilter implements BuilderInterface
{
    /**
     * @var BuilderInterface
     */
    private $filter;

    /**
     * Sets a filter.
     *
     * @param BuilderInterface $filter
     */
    public function __construct(BuilderInterface $filter = null)
    {
        if ($this->filter !== null) {
            $this->setFilter($filter);
        }
    }
    
    /**
     * Checks if bool filter is relevant.
     *
     * @return bool
     *
     * @deprecated Will be removed in 1.0. Use getFilter() method.
     */
    public function isRelevant()
    {
        return isset($this->filter);
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
    public function toArray()
    {
        return [$this->getFilter()->getType() => $this->getFilter()->toArray()];
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'post_filter';
    }
}
