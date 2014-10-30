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
 * Represents Elasticsearch "and" filter.
 */
class AndFilter implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var BuilderInterface[]
     */
    private $filters;

    /**
     * @param BuilderInterface[] $filters    Array.
     * @param array              $parameters Optional parameters.
     */
    public function __construct($filters, array $parameters = [])
    {
        $this->filters = $filters;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'and';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [];

        foreach ($this->filters as $filter) {
            $query['filters'][] = [$filter->getType() => $filter->toArray()];
        }

        $output = $this->processArray($query);

        return $output;
    }
}
