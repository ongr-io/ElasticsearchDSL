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
 * Container for friendly builders.
 */
class FriendlyBuilderBag
{
    /**
     * @var FriendlyBuilderInterface[]
     */
    private $bag = [];

    /**
     * @param FriendlyBuilderInterface[] $builders
     */
    public function __construct(array $builders = [])
    {
        $this->set($builders);
    }

    /**
     * Replaces builders with new ones.
     *
     * @param FriendlyBuilderInterface[] $builders
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
     * @param FriendlyBuilderInterface $builder
     */
    public function add(FriendlyBuilderInterface $builder)
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
     * @return FriendlyBuilderInterface
     */
    public function get($name)
    {
        return $this->bag[$name];
    }

    /**
     * Returns all builders contained.
     *
     * @param string|null $name Builder name.
     *
     * @return FriendlyBuilderInterface[]
     */
    public function all($name = null)
    {
        return array_filter(
            $this->bag,
            function ($builder) use ($name) {
                /** @var FriendlyBuilderInterface $builder */

                return $name === null || $builder->getName() == $name;
            }
        );
    }
}
