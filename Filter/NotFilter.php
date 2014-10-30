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
 * Represents Elasticsearch "not" filter.
 */
class NotFilter implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var BuilderInterface
     */
    private $filter;

    /**
     * @param BuilderInterface $filter     Filter.
     * @param array            $parameters Optional parameters.
     */
    public function __construct($filter, array $parameters = [])
    {
        $this->filter = $filter;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'not';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query['filter'] = [$this->filter->getType() => $this->filter->toArray()];

        $output = $this->processArray($query);

        return $output;
    }
}
