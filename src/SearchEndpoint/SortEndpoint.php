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

namespace ONGR\ElasticsearchDSL\SearchEndpoint;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SortEndpoint extends AbstractSearchEndpoint
{
    public const NAME = 'sort';

    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = []): array
    {
        $output = [];

        foreach ($this->getAll() as $sort) {
            $output[] = $sort->toArray();
        }

        return $output;
    }
}
