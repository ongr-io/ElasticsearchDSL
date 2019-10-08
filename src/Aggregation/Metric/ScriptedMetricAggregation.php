<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;
use ONGR\ElasticsearchDSL\ScriptAwareTrait;

/**
 * Class representing StatsAggregation.
 *
 * @link http://goo.gl/JbQsI3
 */
class ScriptedMetricAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * @var mixed
     */
    private $initScript;

    /**
     * @var mixed
     */
    private $mapScript;

    /**
     * @var mixed
     */
    private $combineScript;

    /**
     * @var mixed
     */
    private $reduceScript;
    /**
     * ScriptedMetricAggregation constructor.
     * @param string $name
     * @param mixed $initScript
     * @param mixed $mapScript
     * @param mixed $combineScript
     * @param mixed $reduceScript
     */
    public function __construct(
        $name,
        $initScript = null,
        $mapScript = null,
        $combineScript = null,
        $reduceScript = null
    ) {
    
        parent::__construct($name);

        $this->setInitScript($initScript);
        $this->setMapScript($mapScript);
        $this->setCombineScript($combineScript);
        $this->setReduceScript($reduceScript);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'scripted_metric';
    }

    /**
     * @return mixed
     */
    public function getInitScript()
    {
        return $this->initScript;
    }

    /**
     * @param mixed $initScript
     *
     * @return $this
     */
    public function setInitScript($initScript)
    {
        $this->initScript = $initScript;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMapScript()
    {
        return $this->mapScript;
    }

    /**
     * @param mixed $mapScript
     *
     * @return $this
     */
    public function setMapScript($mapScript)
    {
        $this->mapScript = $mapScript;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCombineScript()
    {
        return $this->combineScript;
    }

    /**
     * @param mixed $combineScript
     *
     * @return $this
     */
    public function setCombineScript($combineScript)
    {
        $this->combineScript = $combineScript;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getReduceScript()
    {
        return $this->reduceScript;
    }

    /**
     * @param mixed $reduceScript
     *
     * @return $this
     */
    public function setReduceScript($reduceScript)
    {
        $this->reduceScript = $reduceScript;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $out = array_filter(
            [
                'init_script' => $this->getInitScript(),
                'map_script' => $this->getMapScript(),
                'combine_script' => $this->getCombineScript(),
                'reduce_script' => $this->getReduceScript(),
            ]
        );

        return $out;
    }
}
