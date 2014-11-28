<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Suggester\Context;

/**
 * Abstract context to be used by geo context and category context.
 */
abstract class AbstractContext
{
    /**
     * Name of the context used.
     *
     * @var string
     */
    private $name;

    /**
     * Value of the context.
     *
     * @var string|array
     */
    private $value;

    /**
     * Constructor.
     *
     * @param string       $name  Context name.
     * @param array|string $value Context value.
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Converts context to an array.
     *
     * @return array
     */
    abstract public function toArray();

    /**
     * Returns name of the context.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets type of the context.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param array|string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
