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

use ONGR\ElasticsearchDSL\InnerHit\NestedInnerHit;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search inner hits dsl endpoint.
 */
class InnerHitsEndpoint extends AbstractSearchEndpoint
{
    /**
     * Endpoint name
     */
    const NAME = 'inner_hits';

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = [])
    {
        $output = [];
        if (count($this->getAll()) > 0) {
            /** @var NestedInnerHit $innerHit */
            foreach ($this->getAll() as $innerHit) {
                $output[$innerHit->getName()] = $innerHit->toArray();
            }
        }

        return $output;
    }
}
