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

use ONGR\ElasticsearchBundle\DSL\Aggregation\Type\MetricTrait;
use ONGR\ElasticsearchBundle\DSL\ScriptAwareTrait;

/**
 * Class representing PercentilesAggregation.
 */
class PercentilesAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    /**
     * @var array
     */
    private $percents;

    /**
     * @var int
     */
    private $compression;

    /**
     * @return array
     */
    public function getPercents()
    {
        return $this->percents;
    }

    /**
     * @param array $percents
     */
    public function setPercents($percents)
    {
        $this->percents = $percents;
    }

    /**
     * @return int
     */
    public function getCompression()
    {
        return $this->compression;
    }

    /**
     * @param int $compression
     */
    public function setCompression($compression)
    {
        $this->compression = $compression;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'percentiles';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $out = [];

        if ($this->getField()) {
            $out['field'] = $this->getField();
        } elseif ($this->getScript()) {
            $out['script'] = $this->getScript();
        } else {
            throw new \LogicException('Percentiles aggregation must have field or script set.');
        }

        if ($this->getCompression()) {
            $out['compression'] = $this->getCompression();
        }

        if ($this->getPercents()) {
            $out['percents'] = $this->getPercents();
        }

        return $out;
    }
}
