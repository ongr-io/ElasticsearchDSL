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

use ONGR\ElasticsearchDSL\Filter\PostFilter;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search post filter dsl endpoint.
 */
class PostFilterEndpoint extends FilterEndpoint
{
    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        $builder = $this->getBuilderForNormalization();

        if (empty($builder)) {
            return null;
        }

        $postFilter = new PostFilter();
        $postFilter->setFilter($builder);

        return $postFilter->toArray();
    }
}
