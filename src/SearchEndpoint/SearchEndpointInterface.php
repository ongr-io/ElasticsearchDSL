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
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

interface SearchEndpointInterface extends NormalizableInterface
{
    public function add(BuilderInterface $builder, ?string $key = null): ?string;

    public function addToBool(BuilderInterface $builder, string $boolType = null, string $key = null): string;

    public function remove(string $key): static;

    public function get(string $key): ?BuilderInterface;

    public function getAll(?string $boolType = null): array;

    public function getBool(): ?BoolQuery;
}
