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

class DerivativeAggregation extends AbstractPipelineAggregation
{
    /**
     * @var string
     */
    private $format;

    /**
     * @param string $name
     * @param string $bucketsPath
     * @param string $gapPolicy
     * @param string $format
     */
    public function __construct($name, $bucketsPath, $gapPolicy = null, $format = null)
    {
        parent::__construct($name);
        $this->setBucketsPath($bucketsPath);
        !$format ? : $this->setFormat($format);
        !$gapPolicy ? : $this->setGapPolicy($gapPolicy);
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        return array_filter(
            [
                'buckets_path' => $this->getBucketsPath(),
                'gap_policy' => $this->getGapPolicy(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getPipelineFamily()
    {
        return 'parent';
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'derivative';
    }
}
