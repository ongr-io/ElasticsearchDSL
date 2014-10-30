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

use ONGR\ElasticsearchBundle\DSL\Bool\Bool;
use ONGR\ElasticsearchBundle\DSL\BuilderInterface;

/**
 * AbstractFilter class.
 */
abstract class AbstractFilter
{
    /**
     * @var BuilderInterface
     */
    protected $filters;

    /**
     * @param array $boolParams Bool parameters.
     *
     * @internal param bool $filters Filters collection.
     */
    public function __construct($boolParams = [])
    {
        $this->filters = new Bool();
        $this->filters->setParameters($boolParams);
    }

    /**
     * @param BuilderInterface $filter   Filter.
     * @param string           $boolType Possible boolType values:
     *                                   - must
     *                                   - must_not
     *                                   - should.
     */
    public function addFilter(BuilderInterface $filter, $boolType = 'must')
    {
        $this->filters->addToBool($filter, $boolType);
    }

    /**
     * Overrides filters.
     *
     * @param BuilderInterface $filters
     *
     * @return $this
     */
    public function setFilter(BuilderInterface $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @param array $boolParams
     */
    public function setBoolParameters($boolParams)
    {
        $this->filters->setParameters($boolParams);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output[$this->filters->getType()] = $this->filters->toArray();

        return $output;
    }
}
