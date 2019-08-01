<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * Class representing Bucket Script Pipeline Aggregation.
 *
 * @link https://goo.gl/miVxcx
 */
class BucketScriptAggregation extends AbstractPipelineAggregation
{
    /**
     * @var string
     */
    private $script;

    /**
     * @param string $name
     * @param array  $bucketsPath
     * @param string $script
     */
    public function __construct($name, $bucketsPath, $script = null)
    {
        parent::__construct($name, $bucketsPath);
        $this->setScript($script);
    }

    /**
     * @return string
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @param string $script
     *
     * @return $this
     */
    public function setScript($script)
    {
        $this->script = $script;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'bucket_script';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        if (!$this->getScript()) {
            throw new \LogicException(
                sprintf(
                    '`%s` aggregation must have script set.',
                    $this->getName()
                )
            );
        }

        $out = [
            'buckets_path' => $this->getBucketsPath(),
            'script' => $this->getScript(),
        ];

        return $out;
    }
}
