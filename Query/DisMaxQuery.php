<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Query;

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;
use ONGR\ElasticsearchBundle\DSL\ParametersTrait;

/**
 * Elasticsearch dis max query class.
 */
class DisMaxQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var BuilderInterface[]
     */
    private $queries = [];

    /**
     * Initializes Dis Max query.
     *
     * @param BuilderInterface[] $queries
     * @param array              $parameters
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $queries = [], array $parameters = [])
    {
        foreach ($queries as $query) {
            if ($query instanceof BuilderInterface) {
                $this->queries[] = $query;
            } else {
                throw new \InvalidArgumentException('Arguments must be instance of BuilderInterface');
            }
        }
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'dis_max';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        foreach ($this->queries as $type) {
            $query['queries'][] = [$type->getType() => $type->toArray()];
        }
        $output = $this->processArray($query);

        return $output;
    }
}
