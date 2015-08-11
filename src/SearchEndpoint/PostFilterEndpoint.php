<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\SearchEndpoint;

use ONGR\ElasticsearchDSL\Filter\BoolFilter;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search post filter dsl endpoint.
 */
class PostFilterEndpoint extends FilterEndpoint
{
    /**
     * Endpoint name
     */
    const NAME = 'post_filter';

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        if (!$this->getBool()) {
            return null;
        }

        if (!$this->getBool()->isRelevant()) {
            $filters = $this->getBool()->getQueries(BoolFilter::MUST);
            $filter = array_shift($filters);
        } else {
            $filter = $this->getBool();
        }

        return [$filter->getType() => $filter->toArray()];
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
