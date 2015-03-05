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

use ONGR\ElasticsearchBundle\DSL\Aggregation\Type\BucketingTrait;

/**
 * Class representing missing aggregation.
 */
class MissingAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        if ($this->getField()) {
            return ['field' => $this->getField()];
        }
        throw new \LogicException('Missing aggregation must have a field set.');
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'missing';
    }
}
