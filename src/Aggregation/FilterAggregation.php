<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Aggregation;

use ONGR\ElasticsearchBundle\DSL\Aggregation\Type\BucketingTrait;
use ONGR\ElasticsearchBundle\DSL\BuilderInterface;

/**
 * Class representing FilterAggregation.
 */
class FilterAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var BuilderInterface
     */
    protected $filter;

    /**
     * Sets a filter.
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
    public function setField($field)
    {
        throw new \LogicException("Filter aggregation, doesn't support `field` parameter");
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        if (!$this->filter) {
            throw new \LogicException("Filter aggregation `{$this->getName()}` has no filter added");
        }

        $filterData = [$this->filter->getType() => $this->filter->toArray()];

        return $filterData;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'filter';
    }
}
