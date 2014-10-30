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

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;

/**
 * AbstractAggregation class.
 */
abstract class AbstractAggregation implements BuilderInterface
{
    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Aggregations
     */
    public $aggregations;

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
        $this->aggregations = new Aggregations();
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
     * @return string
     */
    public function getName()
    {
        return Aggregations::PREFIX . $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $result = [$this->getName() => [$this->getType() => $this->getArray()]];

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
        $nested = $this->aggregations->all();
        foreach ($nested as $aggregation) {
            $result = array_merge($result, $aggregation->toArray());
        }

        return $result;
    }
}
