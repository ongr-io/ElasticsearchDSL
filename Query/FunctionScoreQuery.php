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

    const USE_QUERY = 'query';
    const USE_FILTER = 'filter';

    /**
     * @var string
     */
    private $dslType;

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
     * @param string           $dslType
     */
    public function __construct(
        BuilderInterface $query,
        array $functions,
        array $parameters = [],
        $dslType = self::USE_FILTER
    ) {
        $this->dslType = $dslType;
        $this->query = $query;
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
                $this->query->getType() => $this->query->toArray(),
            ],
            'functions' => [$this->functions],
        ];

        $output = $this->processArray($query);

        return $output;
    }
}
