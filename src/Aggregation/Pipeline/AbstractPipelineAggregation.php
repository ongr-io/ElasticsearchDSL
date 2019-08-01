<?php

namespace ONGR\ElasticsearchDSL\Aggregation\Pipeline;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;

abstract class AbstractPipelineAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * @var string
     */
    private $bucketsPath;

    /**
     * @param string $name
     * @param $bucketsPath
     */
    public function __construct($name, $bucketsPath = null)
    {
        parent::__construct($name);
        $this->setBucketsPath($bucketsPath);
    }

    /**
     * @return string
     */
    public function getBucketsPath()
    {
        return $this->bucketsPath;
    }

    /**
     * @param string $bucketsPath
     *
     * @return $this
     */
    public function setBucketsPath($bucketsPath)
    {
        $this->bucketsPath = $bucketsPath;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        return ['buckets_path' => $this->getBucketsPath()];
    }
}
