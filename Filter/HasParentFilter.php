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
use ONGR\ElasticsearchBundle\DSL\ParametersTrait;

/**
 * Elasticsearch has_parent filter.
 */
class HasParentFilter implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $parentType;

    /**
     * @var BuilderInterface
     */
    private $filter;

    /**
     * @param string           $parentType
     * @param BuilderInterface $filter
     * @param array            $parameters
     */
    public function __construct($parentType, BuilderInterface $filter, array $parameters = [])
    {
        $this->parentType = $parentType;
        $this->filter = $filter;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'has_parent';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            'parent_type' => $this->parentType,
            'filter' => [
                $this->filter->getType() => $this->filter->toArray(),
            ],
        ];

        $output = $this->processArray($query);

        return $output;
    }
}
