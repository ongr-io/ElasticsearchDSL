<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\SearchEndpoint;

use ONGR\ElasticsearchBundle\DSL\Filter\PostFilter;
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
        if ($this->getBuilder()) {
            $postFilter = new PostFilter();
            !$this->isBool() ? : $this->getBuilder()->setParameters($this->getParameters());
            $postFilter->setFilter($this->getBuilder());

            return $postFilter->toArray();
        }

        return null;
    }
}
