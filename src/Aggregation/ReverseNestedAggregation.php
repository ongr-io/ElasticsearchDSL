<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;

/**
 * Class representing ReverseNestedAggregation.
 */
class ReverseNestedAggregation extends AbstractAggregation
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
        return 'reverse_nested';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        if (count($this->getAggregations()) == 0) {
            throw new \LogicException("Reverse Nested aggregation `{$this->getName()}` has no aggregations added");
        }

        $data = new \stdClass();
        if ($this->getPath()) {
            $data = ['path' => $this->getPath()];
        }

        return $data;
    }
}
