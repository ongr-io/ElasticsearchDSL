<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\InnerHit;

use ONGR\ElasticsearchDSL\BuilderBag;
use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\NameAwareTrait;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * AbstractAggregation class.
 */
abstract class AbstractInnerHit implements BuilderInterface
{
    use ParametersTrait;
    use NameAwareTrait;

    /**
     * @var string
     */
    private $path;

    /**
     * @var BuilderInterface
     */
    private $query;

    /**
     * @var BuilderBag
     */
    private $innerHits;

    /**
     * {@inheritdoc}
     */
    abstract public function toArray();

    /**
     * {@inheritdoc}
     */
    abstract public function getType();

    /**
     * Inner hits container init.
     *
     * @param string           $name
     * @param string           $path
     * @param BuilderInterface $query
     */
    public function __construct($name, $path, BuilderInterface $query)
    {
        $this->setName($name);
        $this->setPath($path);
        $this->setQuery($query);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return BuilderInterface
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param BuilderInterface $query
     */
    public function setQuery(BuilderInterface $query)
    {
        $this->query = $query;
    }

    /**
     * Adds a sub-innerHit.
     *
     * @param AbstractInnerHit $abstractInnerHit
     */
    public function addInnerHit(AbstractInnerHit $abstractInnerHit)
    {
        if (!$this->innerHits) {
            $this->innerHits = new BuilderBag();
        }

        $this->innerHits->add($abstractInnerHit);
    }

    /**
     * Returns all sub inner hits.
     *
     * @return BuilderInterface[]
     */
    public function getInnerHits()
    {
        if ($this->innerHits) {
            return $this->innerHits->all();
        } else {
            return [];
        }
    }

    /**
     * Returns sub inner hit.
     * @param string $name inner hit name to return.
     *
     * @return AbstractInnerHit|null
     */
    public function getInnerHit($name)
    {
        if ($this->innerHits && $this->innerHits->has($name)) {
            return $this->innerHits->get($name);
        } else {
            return null;
        }
    }

    /**
     * Process all nested inner hits.
     *
     * @return array
     */
    public function collectNestedInnerHits()
    {
        $result = [];
        /** @var AbstractInnerHit $innerHit */
        foreach ($this->getInnerHits() as $innerHit) {
            $result[$innerHit->getName()] = $innerHit->toArray();
        }

        return $result;
    }
}
