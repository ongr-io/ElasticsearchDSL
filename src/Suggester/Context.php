<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Suggester;

use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Abstract context to be used by geo context and category context.
 */
class Context implements ContextInterface
{
    use ParametersTrait;

    const TYPE_CATEGORY = 'category';
    const TYPE_GEO_LOCATION = 'location';

    /**
     * @var string Name of the context used.
     */
    private $name;

    /**
     * @var string|array Value of the context.
     */
    private $value;

    /**
     * @var string
     */
    private $type;

    /**
     * Constructor.
     *
     * @param string       $name
     * @param array|string $value
     * @param string       $type
     * @param array        $parameters
     */
    public function __construct($name, $value, $type = self::TYPE_CATEGORY, $parameters = [])
    {
        $this
            ->setName($name)
            ->setValue($value)
            ->setType($type)
            ->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        if ($this->getType() == self::TYPE_CATEGORY) {
            return $this->getValue();
        } else {
            return $this->processArray(['value' => $this->getValue()]);
        }
    }

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
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
