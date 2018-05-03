<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query\Compound;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "function_score" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-function-score-query.html
 */
class FunctionScoreQuery implements BuilderInterface
{
    use ParametersTrait;

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
     * @param array            $parameters
     */
    public function __construct(BuilderInterface $query, array $parameters = [])
    {
        $this->query = $query;
        $this->setParameters($parameters);
    }

    /**
     * Creates field_value_factor function.
     *
     * @param string           $field
     * @param float            $factor
     * @param string           $modifier
     * @param BuilderInterface $query
     *
     * @return $this
     */
    public function addFieldValueFactorFunction($field, $factor, $modifier = 'none', BuilderInterface $query = null)
    {
        $function = [
            'field_value_factor' => [
                'field' => $field,
                'factor' => $factor,
                'modifier' => $modifier,
            ],
        ];

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Modifier to apply filter to the function score function.
     *
     * @param array            $function
     * @param BuilderInterface $query
     */
    private function applyFilter(array &$function, BuilderInterface $query = null)
    {
        if ($query) {
            $function['filter'] = $query->toArray();
        }
    }

    /**
     * Add decay function to function score. Weight and query are optional.
     *
     * @param string           $type
     * @param string           $field
     * @param array            $function
     * @param array            $options
     * @param BuilderInterface $query
     * @param int              $weight
     *
     * @return $this
     */
    public function addDecayFunction(
        $type,
        $field,
        array $function,
        array $options = [],
        BuilderInterface $query = null,
        $weight = null
    ) {
        $function = array_filter(
            [
                $type => array_merge(
                    [$field => $function],
                    $options
                ),
                'weight' => $weight,
            ]
        );

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds function to function score without decay function. Influence search score only for specific query.
     *
     * @param float            $weight
     * @param BuilderInterface $query
     *
     * @return $this
     */
    public function addWeightFunction($weight, BuilderInterface $query = null)
    {
        $function = [
            'weight' => $weight,
        ];

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds random score function. Seed is optional.
     *
     * @param mixed            $seed
     * @param BuilderInterface $query
     *
     * @return $this
     */
    public function addRandomFunction($seed = null, BuilderInterface $query = null)
    {
        $function = [
            'random_score' => $seed ? [ 'seed' => $seed ] : new \stdClass(),
        ];

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds script score function.
     *
     * @param string           $inline
     * @param array            $params
     * @param array            $options
     * @param BuilderInterface $query
     *
     * @return $this
     */
    public function addScriptScoreFunction(
        $inline,
        array $params = [],
        array $options = [],
        BuilderInterface $query = null
    ) {
        $function = [
            'script_score' => [
                'script' =>
                    array_filter(
                        array_merge(
                            [
                                'lang' => 'painless',
                                'inline' => $inline,
                                'params' => $params
                            ],
                            $options
                        )
                    )
            ],
        ];

        $this->applyFilter($function, $query);
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
            'query' => $this->query->toArray(),
            'functions' => $this->functions,
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'function_score';
    }
}
