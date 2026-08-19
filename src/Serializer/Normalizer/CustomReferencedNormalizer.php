<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\CustomNormalizer;

class CustomReferencedNormalizer extends CustomNormalizer
{
    private array $references = [];

    public function normalize($object, $format = null, array $context = []): mixed
    {
        $object->setReferences($this->references);
        $data = parent::normalize($object, $format, $context);
        $this->references = array_merge($this->references, $object->getReferences());

        return $data;
    }

    public function supportsNormalization(mixed $data, $format = null): bool
    {
        return $data instanceof AbstractNormalizable;
    }
}
