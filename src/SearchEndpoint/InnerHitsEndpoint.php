<?php

namespace ONGR\ElasticsearchDSL\SearchEndpoint;

use ONGR\ElasticsearchDSL\InnerHit\NestedInnerHit;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class InnerHitsEndpoint extends AbstractSearchEndpoint
{
    public const NAME = 'inner_hits';

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
