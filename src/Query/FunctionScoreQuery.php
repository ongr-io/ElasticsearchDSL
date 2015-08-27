<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\DslTypeAwareTrait;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Elasticsearch function_score query class.
 */
class FunctionScoreQuery implements BuilderInterface
{
    use ParametersTrait;
    use DslTypeAwareTrait;

    /**
     * Query of filter.
     *
     * In Function score could be used query or filter. Use setDslType() to change type.
     *
     * @var BuilderInterface
     */
    private $query;

    /**
     * @var array[]
     */
    private $functions;

    /**
     * @param BuilderInterface $query
     * @param array            $parameters
     */
    public function __construct(BuilderInterface $query, array $parameters = [])
    {
        $this->query = $query;
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
     * Modifier to apply filter to the function score function.
     *
     * @param array            $function
     * @param BuilderInterface $filter
     */
    private function applyFilter(array &$function, BuilderInterface $filter = null)
    {
        if ($filter) {
            $function['filter'] = [
                $filter->getType() => $filter->toArray(),
            ];
        }
    }

    /**
     * Creates field_value_factor function.
     *
     * @param string           $field
     * @param float            $factor
     * @param string           $modifier
     * @param BuilderInterface $filter
     *
     * @return $this
     */
    public function addFieldValueFactorFunction($field, $factor, $modifier = 'none', BuilderInterface $filter = null)
    {
        $function = [
            'field_value_factor' => [
                'field' => $field,
                'factor' => $factor,
                'modifier' => $modifier,
            ],
        ];

        $this->applyFilter($function, $filter);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Add decay function to function score. Weight and filter are optional.
     *
     * @param string           $type
     * @param string           $field
     * @param array            $function
     * @param array            $options
     * @param BuilderInterface $filter
     *
     * @return $this
     */
    public function addDecayFunction(
        $type,
        $field,
        array $function,
        array $options = [],
        BuilderInterface $filter = null
    ) {
        $function = [
            $type => array_merge(
                [$field => $function],
                $options
            ),
        ];

        $this->applyFilter($function, $filter);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds function to function score without decay function. Influence search score only for specific filter.
     *
     * @param float            $weight
     * @param BuilderInterface $filter
     *
     * @return $this
     */
    public function addWeightFunction($weight, BuilderInterface $filter = null)
    {
        $function = [
            'weight' => $weight,
        ];

        $this->applyFilter($function, $filter);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds random score function. Seed is optional.
     *
     * @param mixed            $seed
     * @param BuilderInterface $filter
     *
     * @return $this
     */
    public function addRandomFunction($seed = null, BuilderInterface $filter = null)
    {
        $function = [
            'random_score' => $seed ? [ 'seed' => $seed ] : new \stdClass(),
        ];

        $this->applyFilter($function, $filter);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds script score function.
     *
     * @param string           $script
     * @param array            $params
     * @param array            $options
     * @param BuilderInterface $filter
     *
     * @return $this
     */
    public function addScriptScoreFunction(
        $script,
        array $params = [],
        array $options = [],
        BuilderInterface $filter = null
    ) {
        $function = [
            'script_score' => [
                'script' => $script,
                'params' => $params,
                $options
            ],
        ];

        $this->applyFilter($function, $filter);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds custom simple function. You can add to the array whatever you want.
     *
     * @param array $function
     *
     * @return $this
     */
    public function addSimpleFunction(array $function)
    {
        $this->functions[] = $function;

        return $this;
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
            'functions' => $this->functions,
        ];

        $output = $this->processArray($query);

        return $output;
    }
}
