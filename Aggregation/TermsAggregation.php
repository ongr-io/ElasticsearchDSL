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
use ONGR\ElasticsearchBundle\DSL\ScriptAwareTrait;

/**
 * Class representing TermsAggregation.
 */
class TermsAggregation extends AbstractAggregation
{
    use BucketingTrait;
    use ScriptAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'terms';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $data = array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
            ]
        );

        return $data;
    }
}
