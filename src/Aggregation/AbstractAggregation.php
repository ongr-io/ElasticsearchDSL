<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Aggregation;

use ONGR\ElasticsearchBundle\DSL\NamedBuilderBag;
use ONGR\ElasticsearchBundle\DSL\NamedBuilderInterface;
use ONGR\ElasticsearchBundle\DSL\ParametersTrait;

/**
 * AbstractAggregation class.
 */
abstract class AbstractAggregation implements NamedBuilderInterface
{
    use ParametersTrait;

    const PREFIX = 'agg_';

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $name;

    /**
     * @var NamedBuilderBag
     */
    private $aggregations;

    /**
     * @return string
     */
    abstract public function getType();

    /**
     * Abstract supportsNesting method.
     *
     * @return bool
     */
    abstract protected function supportsNesting();

    /**
     * @return array|\stdClass
     */
    abstract protected function getArray();

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->aggregations = new NamedBuilderBag();
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::PREFIX . $this->name;
    }

    /**
     * Adds a sub-aggregation.
     *
     * @param AbstractAggregation $abstractAggregation
     */
    public function addAggregation(AbstractAggregation $abstractAggregation)
    {
        $this->aggregations->add($abstractAggregation);
    }

    /**
     * Returns all sub aggregations.
     *
     * @return AbstractAggregation[]
     */
    public function getAggregations()
    {
        return $this->aggregations->all();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $array = $this->getArray();
        $result = [
            $this->getName() => [
                $this->getType() => is_array($array) ? $this->processArray($array) : $array,
            ],
        ];

        if ($this->supportsNesting()) {
            $nestedResult = $this->collectNestedAggregations();

            if (!empty($nestedResult)) {
                $result[$this->getName()]['aggregations'] = $nestedResult;
            }
        }

        return $result;
    }

    /**
     * Process all nested aggregations.
     *
     * @return array
     */
    protected function collectNestedAggregations()
    {
        $result = [];
        foreach ($this->getAggregations() as $aggregation) {
            $result = array_merge($result, $aggregation->toArray());
        }

        return $result;
    }
}
