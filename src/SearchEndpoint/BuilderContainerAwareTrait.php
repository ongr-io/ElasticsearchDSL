<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\SearchEndpoint;

use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Trait to implement SearchEndpointInterface builder methods.
 */
trait BuilderContainerAwareTrait
{
    /**
     * @var BuilderInterface[]
     */
    private $builderContainer = [];

    /**
     * @var array
     */
    private $parameterContainer = [];

    /**
     * {@inheritdoc}
     */
    public function addBuilder(BuilderInterface $builder, $parameters = [])
    {
        $this->builderContainer[] = $builder;
        end($this->builderContainer);
        $key = key($this->builderContainer);

        $this->parameterContainer[$key] = $parameters;

        return $key;
    }

    /**
     * {@inheritdoc}
     */
    public function removeBuilder($key)
    {
        if (array_key_exists($key, $this->builderContainer)) {
            unset($this->builderContainer[$key]);
            unset($this->parameterContainer[$key]);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBuilder($key)
    {
        if (array_key_exists($key, $this->builderContainer)) {
            return $this->builderContainer[$key];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getBuilders()
    {
        return $this->builderContainer;
    }

    /**
     * {@inheritdoc}
     */
    public function getBuilderParameters($key)
    {
        if (array_key_exists($key, $this->parameterContainer)) {
            return $this->parameterContainer[$key];
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function setBuilderParameters($key, $parameters)
    {
        $this->parameterContainer[$key] = $parameters;

        return $this;
    }
}
