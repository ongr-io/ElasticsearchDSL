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
use ONGR\ElasticsearchBundle\DSL\DslTypeAwareTrait;
use ONGR\ElasticsearchBundle\DSL\ParametersTrait;

/**
 * Elasticsearch function_score query class.
 */
class FunctionScoreQuery implements BuilderInterface
{
    use ParametersTrait;
    use DslTypeAwareTrait;

    /**
     * @var BuilderInterface
     */
    private $query;

    /**
     * @var array[]
     */
    private $functions;

    /**
     * @param BuilderInterface $query
     * @param array            $functions
     * @param array            $parameters
     */
    public function __construct(BuilderInterface $query, array $functions, array $parameters = [])
    {
        $this->query = $query;
        $this->functions = $functions;
        $this->setParameters($parameters);
        $this->setDslType('query');
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'function_score';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            strtolower($this->getDslType()) => [
                $this->query->getType() => $this->query->toArray(),
            ],
            'functions' => [$this->functions],
        ];

        $output = $this->processArray($query);

        return $output;
    }
}
