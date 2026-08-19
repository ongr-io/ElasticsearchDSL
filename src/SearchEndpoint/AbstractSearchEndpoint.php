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
use ONGR\ElasticsearchDSL\ParametersTrait;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Serializer\Normalizer\AbstractNormalizable;

/**
 * Abstract class used to define search endpoint with references.
 */
abstract class AbstractSearchEndpoint extends AbstractNormalizable implements SearchEndpointInterface
{
    use ParametersTrait;

    private array $container = [];

    public function add(BuilderInterface $builder, string $key = null): ?string
    {
        if (array_key_exists($key, $this->container)) {
            throw new \OverflowException(sprintf('Builder with %s name for endpoint has already been added!', $key));
        }

        if (!$key) {
            $key = bin2hex(random_bytes(30));
        }

        $this->container[$key] = $builder;

        return $key;
    }

    public function addToBool(BuilderInterface $builder, ?string $boolType = null, ?string $key = null): string
    {
        throw new \BadFunctionCallException(sprintf("Endpoint %s doesn't support bool statements", static::NAME));
    }

    public function remove(string $key): static
    {
        if ($this->has($key)) {
            unset($this->container[$key]);
        }

        return $this;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->container);
    }

    public function get(string $key): ?BuilderInterface
    {
        if ($this->has($key)) {
            return $this->container[$key];
        }

        return null;
    }

    public function getAll(?string $boolType = null): array
    {
        return $this->container;
    }

    public function getBool(): ?BoolQuery
    {
        throw new \BadFunctionCallException(sprintf("Endpoint %s doesn't support bool statements", static::NAME));
    }
}
