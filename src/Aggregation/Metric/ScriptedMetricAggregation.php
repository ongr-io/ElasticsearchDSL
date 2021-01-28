<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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

    public function __construct(
        private string $name,
        private mixed $initScript = null,
        private mixed $mapScript = null,
        private mixed $combineScript = null,
        private mixed $reduceScript = null
    ) {
    
        parent::__construct($name);

        $this->setInitScript($initScript);
        $this->setMapScript($mapScript);
        $this->setCombineScript($combineScript);
        $this->setReduceScript($reduceScript);
    }

    public function getType(): string
    {
        return 'scripted_metric';
    }

    public function getInitScript(): mixed
    {
        return $this->initScript;
    }

    public function setInitScript(mixed $initScript): static
    {
        $this->initScript = $initScript;

        return $this;
    }

    public function getMapScript(): mixed
    {
        return $this->mapScript;
    }

    public function setMapScript(mixed $mapScript): static
    {
        $this->mapScript = $mapScript;

        return $this;
    }

    public function getCombineScript(): mixed
    {
        return $this->combineScript;
    }

    public function setCombineScript(mixed $combineScript): static
    {
        $this->combineScript = $combineScript;

        return $this;
    }

    public function getReduceScript(): mixed
    {
        return $this->reduceScript;
    }

    public function setReduceScript(mixed $reduceScript): static
    {
        $this->reduceScript = $reduceScript;

        return $this;
    }


    public function getArray(): array
    {
        return array_filter(
            [
                'init_script' => $this->getInitScript(),
                'map_script' => $this->getMapScript(),
                'combine_script' => $this->getCombineScript(),
                'reduce_script' => $this->getReduceScript(),
            ]
        );
    }
}
