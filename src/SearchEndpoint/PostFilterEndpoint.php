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

class PostFilterEndpoint extends QueryEndpoint
{
    public const NAME = 'post_filter';

    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = [])
    {
        if (!$this->getBool()) {
            return null;
        }

        return $this->getBool()->toArray();
    }

    public function getOrder(): int
    {
        return 1;
    }
}
