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
 * Elasticsearch has_child filter.
 */
class HasChildFilter implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $filter;

    /**
     * @param string           $type
     * @param BuilderInterface $filter
     * @param array            $parameters
     */
    public function __construct($type, BuilderInterface $filter, array $parameters = [])
    {
        $this->type = $type;
        $this->filter = $filter;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'has_child';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            'type' => $this->type,
            'filter' => [
                $this->filter->getType() => $this->filter->toArray(),
            ],
        ];

        $output = $this->processArray($query);

        return $output;
    }
}
