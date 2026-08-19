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

use ONGR\ElasticsearchDSL\BuilderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class HighlightEndpoint extends AbstractSearchEndpoint
{
    public const NAME = 'highlight';

    private ?BuilderInterface $highlight = null;

    private ?string $key = null;

    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = [])
    {
        if ($this->highlight) {
            return $this->highlight->toArray();
        }

        return null;
    }

    public function add(BuilderInterface $builder, ?string $key = null): ?string
    {
        if ($this->highlight) {
            throw new \OverflowException('Only one highlight can be set');
        }

        $this->key = $key;
        $this->highlight = $builder;

        return $key;
    }

    public function getAll(?string $boolType = null): array
    {
        return [$this->key => $this->highlight];
    }

    public function getHighlight(): ?BuilderInterface
    {
        return $this->highlight;
    }
}
