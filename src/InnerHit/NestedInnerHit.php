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
 * Represents Elasticsearch top level nested inner hits.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-inner-hits.html
 */
class NestedInnerHit implements BuilderInterface
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
     * Inner hits container init.
     *
     * @param string           $name
     * @param string           $path
     * @param BuilderInterface $query
     */
    public function __construct($name, $path, BuilderInterface $query = null)
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
    public function setQuery(BuilderInterface $query = null)
    {
        $this->query = $query;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'nested';
    }

    /**
     * Adds a sub-innerHit.
     *
     * @param NestedInnerHit $innerHit
     */
    public function addInnerHit(NestedInnerHit $innerHit)
    {
        if (!$this->innerHits) {
            $this->innerHits = new BuilderBag();
        }

        $this->innerHits->add($innerHit);
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
     * @return NestedInnerHit|null
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
     * {@inheritdoc}
     */
    public function toArray()
    {
        $out = array_filter(
            [
                'query' => $this->getQuery() ? $this->getQuery()->toArray() : null,
                'inner_hits' => $this->collectNestedInnerHits(),
            ]
        );

        $out = $this->processArray($out);

        $out = [
            $this->getPathType() => [
                $this->getPath() => $out ? $out : new \stdClass(),
            ],
        ];

        return $out;
    }

    /**
     * Returns 'path' for neted and 'type' for parent inner hits
     *
     * @return null|string
     */
    private function getPathType()
    {
        switch ($this->getType()) {
            case 'nested':
                $type = 'path';
                break;
            case 'parent':
                $type = 'type';
                break;
            default:
                $type = null;
        }
        return $type;
    }

    /**
     * Process all nested inner hits.
     *
     * @return array
     */
    private function collectNestedInnerHits()
    {
        $result = [];
        /** @var NestedInnerHit $innerHit */
        foreach ($this->getInnerHits() as $innerHit) {
            $result[$innerHit->getName()] = $innerHit->toArray();
        }

        return $result;
    }
}
