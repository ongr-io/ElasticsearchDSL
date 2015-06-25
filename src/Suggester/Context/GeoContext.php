<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Suggester\Context;

/**
 * Geo context to be used by context suggester.
 */
class GeoContext extends AbstractContext
{
    /**
     * @var string
     */
    private $precision;

    /**
     * @return mixed
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * @param mixed $precision
     */
    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $out = ['value' => $this->getValue()];

        if ($this->getPrecision() !== null) {
            $out['precision'] = $this->getPrecision();
        }

        return $out;
    }
}
