<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\InnerHit;

use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * AbstractAggregation class.
 */
abstract class AbstractInnerHit implements BuilderInterface
{
    /**
     * {@inheritdoc}
     */
    abstract public function toArray();

    /**
     * {@inheritdoc}
     */
    abstract public function getType();
}
