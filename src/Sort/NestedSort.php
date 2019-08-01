<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Sort;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "nested" sort filter.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/filter-dsl-nested-filter.html
 */
class NestedSort implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $path;

    /**
     * @var BuilderInterface
     */
    private $filter;

    /**
     * @var BuilderInterface
     */
    private $nestedFilter;

    /**
     * @param string $path
     * @param BuilderInterface $filter
     * @param array $parameters
     */
    public function __construct(
        $path,
        BuilderInterface $filter = null,
        array $parameters = []
    ) {
        $this->path = $path;
        $this->filter = $filter;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'nested';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = [
            'path'   => $this->path,
        ];

        if ($this->filter) {
            $output['filter'] = $this->filter->toArray();
        }

        if ($this->nestedFilter) {
            $output[$this->getType()] = $this->nestedFilter->toArray();
        }

        return $this->processArray($output);
    }

    /**
     * Returns nested filter object.
     *
     * @return BuilderInterface
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Returns path this filter is set for.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return BuilderInterface
     */
    public function getNestedFilter()
    {
        return $this->nestedFilter;
    }

    /**
     * @param BuilderInterface $nestedFilter
     *
     * @return $this
     */
    public function setNestedFilter(BuilderInterface $nestedFilter)
    {
        $this->nestedFilter = $nestedFilter;

        return $this;
    }
}
