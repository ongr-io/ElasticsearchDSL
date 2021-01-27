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

class BuilderBag
{
    private array $bag = [];

    public function __construct(array $builders = [])
    {
        foreach ($builders as $builder) {
            $this->add($builder);
        }
    }

    public function add(BuilderInterface $builder): ?string
    {
        $name = bin2hex(random_bytes(30));

        if (method_exists($builder, 'getName')) {
            $name = $builder->getName();
        }

        $this->bag[$name] = $builder;

        return $name;
    }

    public function has(string $name): bool
    {
        return isset($this->bag[$name]);
    }

    public function remove(string $name): void
    {
        unset($this->bag[$name]);
    }

    public function clear(): void
    {
        $this->bag = [];
    }

    public function get(string $name): BuilderInterface
    {
        return $this->bag[$name];
    }

    public function all(?string $type = null): array
    {
        return array_filter(
            $this->bag,
            /** @var BuilderInterface $builder */
            function (BuilderInterface $builder) use ($type) {
                return $type === null || $builder->getType() == $type;
            }
        );
    }

    public function toArray(): array
    {
        $output = [];
        foreach ($this->all() as $builder) {
            $output = array_merge($output, $builder->toArray());
        }

        return $output;
    }
}
