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
 * Class representing Percentile Ranks Aggregation.
 */
class PercentileRanksAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    /**
     * @var array
     */
    private $values;

    /**
     * @var int
     */
    private $compression;

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues($values)
    {
        $this->values = $values;
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
        return 'percentile_ranks';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $out = [];

        if ($this->getField() && $this->getValues()) {
            $out['field'] = $this->getField();
            $out['values'] = $this->getValues();
        } elseif ($this->getScript() && $this->getValues()) {
            $out['script'] = $this->getScript();
            $out['values'] = $this->getValues();
        } else {
            throw new \LogicException(
                'Percentile ranks aggregation must have field and values or script and values set.'
            );
        }

        if ($this->getCompression()) {
            $out['compression'] = $this->getCompression();
        }

        return $out;
    }
}
