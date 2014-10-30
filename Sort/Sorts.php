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
 * Container for sorts.
 */
class Sorts implements BuilderInterface
{
    /**
     * Sorts collection.
     *
     * @var AbstractSort[]
     */
    private $sorts = [];

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'sort';
    }

    /**
     * @param AbstractSort $sort
     */
    public function addSort(AbstractSort $sort)
    {
        $this->sorts[$sort->getType()] = $sort;
    }

    /**
     * Check if we have any sorting set.
     *
     * @return bool
     */
    public function isRelevant()
    {
        return !empty($this->sorts);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $value = [];
        foreach ($this->sorts as $sort) {
            $value[$sort->getType()] = $sort->toArray();
        }

        return $value;
    }
}
