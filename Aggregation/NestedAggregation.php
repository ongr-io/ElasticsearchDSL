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

/**
 * Class representing NestedAggregation.
 */
class NestedAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var string
     */
    private $path;

    /**
     * Return path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets path.
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
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
    public function getArray()
    {
        if (count($this->getAggregations()) == 0) {
            throw new \LogicException("Nested aggregation `{$this->getName()}` has no aggregations added");
        }

        return ['path' => $this->getPath()];
    }
}
