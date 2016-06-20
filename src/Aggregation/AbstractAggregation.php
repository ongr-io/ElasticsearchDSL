<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\Pipeline\AbstractPipelineAggregation;
use ONGR\ElasticsearchDSL\BuilderBag;
use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\NameAwareTrait;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * AbstractAggregation class.
 */
abstract class AbstractAggregation implements BuilderInterface
{
    use ParametersTrait;
    use NameAwareTrait;

    /**
     * @var string
     */
    private $field;

    /**
     * @var BuilderBag
     */
    private $aggregations;

    /**
     * @var BuilderBag[]
     */
    private $pipelines = [];

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
        $this->setName($name);
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
     * Adds a sub-aggregation.
     *
     * @param AbstractAggregation $abstractAggregation
     */
    public function addAggregation(AbstractAggregation $abstractAggregation)
    {
        if (!$this->aggregations) {
            $this->aggregations = $this->createBuilderBag();
        }

        $this->aggregations->add($abstractAggregation);
    }

    /**
     * Adds a sub-aggregation.
     *
     * @param AbstractPipelineAggregation $pipeline
     */
    public function addPipeline(AbstractPipelineAggregation $pipeline)
    {
        $family = $pipeline->getPipelineFamily();
        if (!isset($this->pipelines[$family])) {
            $this->pipelines[$family] = $this->createBuilderBag();
        }

        $this->pipelines[$family]->add($pipeline);
    }

    /**
     * Returns all sibling pipeline aggregations.
     *
     * @return AbstractPipelineAggregation[]
     */
    public function getSiblingPipelines()
    {
        if (isset($this->pipelines['sibling'])) {
            return $this->pipelines['sibling']->all();
        } else {
            return [];
        }
    }

    /**
     * Returns all parent pipeline aggregations.
     *
     * @return AbstractPipelineAggregation[]
     */
    public function getParentPipelines()
    {
        if (isset($this->pipelines['parent'])) {
            return $this->pipelines['parent']->all();
        } else {
            return [];
        }
    }

    /**
     * Checks if pipelines or a given family of pipeline
     * aggregations is set
     *
     * @param string $family
     *
     * @return bool
     */
    public function hasPipelines($family = null)
    {
        return $family ? isset($this->pipelines[$family]) :
            !empty($this->pipelines);
    }


    /**
     * Returns all sub aggregations.
     *
     * @return BuilderBag[]
     */
    public function getAggregations()
    {
        if ($this->aggregations) {
            return $this->aggregations->all();
        } else {
            return [];
        }
    }

    /**
     * Returns sub aggregation.
     * @param string $name Aggregation name to return.
     *
     * @return AbstractAggregation|null
     */
    public function getAggregation($name)
    {
        if ($this->aggregations && $this->aggregations->has($name)) {
            return $this->aggregations->get($name);
        } else {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $array = $this->getArray();
        $result = [
            $this->getType() => is_array($array) ? $this->processArray($array) : $array,
        ];

        if ($this->supportsNesting() || $this->hasPipelines('parent')) {
            $nestedResult = $this->collectNestedAggregations();

            if (!empty($nestedResult)) {
                $result['aggregations'] = $nestedResult;
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
        /** @var AbstractAggregation $aggregation */
        foreach ($this->getAggregations() as $aggregation) {
            $result[$aggregation->getName()] = $aggregation->toArray();
            if ($aggregation->hasPipelines('parent')) {
                foreach ($aggregation->getParentPipelines() as $pipeline) {
                    $result[$pipeline->getName()] = $pipeline->toArray();
                }
            }
        }
        foreach ($this->getParentPipelines() as $pipeline) {
            $result[$pipeline->getName()] = $pipeline->toArray();
        }

        return $result;
    }

    /**
     * Creates BuilderBag new instance.
     *
     * @return BuilderBag
     */
    private function createBuilderBag()
    {
        return new BuilderBag();
    }
}
