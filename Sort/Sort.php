<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Sort;

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;

/**
 * Holds all the values required for basic sorting.
 */
class Sort extends AbstractSort
{
    /**
     * Filter for sorting.
     *
     * @var BuilderInterface
     */
    private $nestedFilter;

    /**
     * @param string           $field        Field name.
     * @param string           $order        Order direction.
     * @param BuilderInterface $nestedFilter Filter for sorting.
     * @param string           $mode         Multi-valued field sorting mode [MODE_MIN, MODE_MAX, MODE_AVG, MODE_SUM].
     */
    public function __construct($field, $order = self::ORDER_ASC, BuilderInterface $nestedFilter = null, $mode = null)
    {
        parent::__construct($field, $order, $mode);
        $this->setNestedFilter($nestedFilter);
    }

    /**
     * Sets nested filter.
     *
     * @param BuilderInterface $nestedFilter
     */
    public function setNestedFilter($nestedFilter)
    {
        $this->nestedFilter = $nestedFilter;
    }

    /**
     * Returns nested filter.
     *
     * @return BuilderInterface
     */
    public function getNestedFilter()
    {
        return $this->nestedFilter;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->getField();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $value = parent::toArray();
        if ($this->getNestedFilter() !== null) {
            $value['nested_filter'][$this->getNestedFilter()->getType()] = $this->getNestedFilter()->toArray();
        }

        return $value;
    }
}
