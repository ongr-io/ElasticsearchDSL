<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL;

/**
 * Container for named builders.
 */
class NamedBuilderBag
{
    /**
     * @var NamedBuilderInterface[]
     */
    private $bag = [];

    /**
     * @param NamedBuilderInterface[] $builders
     */
    public function __construct(array $builders = [])
    {
        $this->set($builders);
    }

    /**
     * Replaces builders with new ones.
     *
     * @param NamedBuilderInterface[] $builders
     */
    public function set(array $builders)
    {
        foreach ($builders as $builder) {
            $this->add($builder);
        }
    }

    /**
     * Adds a builder.
     *
     * @param NamedBuilderInterface $builder
     */
    public function add(NamedBuilderInterface $builder)
    {
        $this->bag[$builder->getName()] = $builder;
    }

    /**
     * Checks if builder is set by name.
     *
     * @param string $name Builder name.
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->bag[$name]);
    }

    /**
     * Removes a builder by name.
     *
     * @param string $name Builder name.
     */
    public function remove($name)
    {
        unset($this->bag[$name]);
    }

    /**
     * Clears contained builders.
     */
    public function clear()
    {
        $this->bag = [];
    }

    /**
     * Returns a builder by name.
     *
     * @param string $name Builder name.
     *
     * @return NamedBuilderInterface
     */
    public function get($name)
    {
        return $this->bag[$name];
    }

    /**
     * Returns all builders contained.
     *
     * @param string|null $type Builder type.
     *
     * @return NamedBuilderInterface[]
     */
    public function all($type = null)
    {
        return array_filter(
            $this->bag,
            /** @var NamedBuilderInterface $builder */
            function ($builder) use ($type) {
                return $type === null || $builder->getType() == $type;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $out = [];
        foreach ($this->all() as $builder) {
            $out = array_merge($out, $builder->toArray());
        }

        return $out;
    }
}
