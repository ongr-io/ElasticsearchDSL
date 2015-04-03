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
 * Class representing Extended stats aggregation.
 */
class ExtendedStatsAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    /**
     * @var int
     */
    private $sigma;

    /**
     * @return int
     */
    public function getSigma()
    {
        return $this->sigma;
    }

    /**
     * @param int $sigma
     */
    public function setSigma($sigma)
    {
        $this->sigma = $sigma;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'extended_stats';
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
            throw new \LogicException('Extended stats aggregation must have field or script set.');
        }

        if ($this->getSigma()) {
            $out['sigma'] = $this->getSigma();
        }

        return $out;
    }
}
