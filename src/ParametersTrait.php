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

namespace ONGR\ElasticsearchDSL;

trait ParametersTrait
{
    private array $parameters = [];

    public function hasParameter(string $name): bool
    {
        return isset($this->parameters[$name]);
    }

    public function removeParameter(string $name): void
    {
        if ($this->hasParameter($name)) {
            unset($this->parameters[$name]);
        }
    }

    public function getParameter(string $name): mixed
    {
        return $this->parameters[$name];
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function addParameter(string $name, mixed $value): void
    {
        $this->parameters[$name] = $value;
    }

    public function setParameters(array $parameters): static
    {
        $this->parameters = $parameters;

        return $this;
    }

    protected function processArray(array $array = []): array
    {
        return array_merge($array, $this->parameters);
    }
}
