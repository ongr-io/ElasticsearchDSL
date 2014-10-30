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

/**
 * Aggregations class.
 */
class Aggregations
{
    const PREFIX = 'agg_';

    /**
     * @var array
     */
    private $aggregations = [];

    /**
     * @param AbstractAggregation $agg
     */
    public function addAggregation(AbstractAggregation $agg)
    {
        $this->aggregations[$agg->getName()] = $agg;
    }

    /**
     * Checks if aggregation is set.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->aggregations[$name]);
    }

    /**
     * Removes aggregation by it's name.
     *
     * @param string $name
     */
    public function remove($name)
    {
        unset($this->aggregations[$name]);
    }

    /**
     * Gets aggregation by it's name.
     *
     * @param string $name
     *
     * @return AbstractAggregation
     */
    public function get($name)
    {
        return $this->aggregations[$name];
    }

    /**
     * Returns all aggregations.
     *
     * @param string|null $type
     *
     * @return AbstractAggregation[]
     */
    public function all($type = null)
    {
        return array_filter(
            $this->aggregations,
            function ($aggregation) use ($type) {
                /** @var AbstractAggregation $aggregation */

                return $type === null || $aggregation->getType() == $type;
            }
        );
    }
}
