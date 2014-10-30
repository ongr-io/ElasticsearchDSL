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
 * Elasticsearch function_score query class.
 */
class FunctionScoreQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $dslType;

    /**
     * @var BuilderInterface
     */
    private $filterOrQuery;

    /**
     * @var array[]
     */
    private $functions;

    /**
     * @param BuilderInterface $filterOrQuery
     * @param array            $functions
     * @param array            $parameters
     */
    public function __construct(BuilderInterface $filterOrQuery, $functions, array $parameters = [])
    {
        $this->dslType = array_slice(explode('\\', get_class($filterOrQuery)), -2, 1)[0];
        $this->filterOrQuery = $filterOrQuery;
        $this->functions = $functions;
        $this->setParameters($parameters);
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
            strtolower($this->dslType) => [
                $this->filterOrQuery->getType() => $this->filterOrQuery->toArray(),
            ],
            'functions' => [$this->functions],
        ];

        $output = $this->processArray($query);

        return $output;
    }
}
