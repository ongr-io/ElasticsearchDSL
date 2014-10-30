<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Bool;

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;
use ONGR\ElasticsearchBundle\DSL\ParametersTrait;

/**
 * Class Bool.
 */
class Bool implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var array
     */
    private $container = [];

    /**
     * Checks if bool filter is relevant.
     *
     * @return bool
     */
    public function isRelevant()
    {
        return (bool)count($this->container);
    }

    /**
     * Add BuilderInterface object ot bool filter.
     *
     * @param BuilderInterface $bool
     * @param string           $type
     */
    public function addToBool(BuilderInterface $bool, $type = 'must')
    {
        $this->container[$type][] = $bool;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'bool';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = $this->processArray();

        foreach ($this->container as $type => $filters) {
            /** @var BuilderInterface $bool */
            foreach ($filters as $bool) {
                $output[$type][] = [$bool->getType() => $bool->toArray()];
            }
        }

        return $output;
    }
}
