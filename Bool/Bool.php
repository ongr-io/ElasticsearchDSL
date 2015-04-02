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
 * Bool operator. Can be used for filters and queries.
 */
class Bool implements BuilderInterface
{
    use ParametersTrait;

    const MUST = 'must';
    const MUST_NOT = 'must_not';
    const SHOULD = 'should';

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
     * Add BuilderInterface object to bool operator.
     *
     * @param BuilderInterface $bool
     * @param string           $type
     *
     * @throws \UnexpectedValueException
     */
    public function addToBool(BuilderInterface $bool, $type = self::MUST)
    {
        $constants = (new \ReflectionObject($this))->getConstants();

        if (!in_array($type, $constants)) {
            throw new \UnexpectedValueException(sprintf('The bool operator %s is not supported', $type));
        }

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
