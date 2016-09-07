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

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\NameAwareTrait;
use ONGR\ElasticsearchDSL\ParametersTrait;
use ONGR\ElasticsearchDSL\Search;

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
     * Inner hits container init.
     *
     * @param string $name
     * @param string $path
     * @param Search $query
     */
    public function __construct($name, $path, Search $query = null)
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
     * @param Search $query
     */
    public function setQuery(Search $query = null)
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
     * {@inheritdoc}
     */
    public function toArray()
    {
        $out = $this->getQuery() ? $this->getQuery()->toArray() : new \stdClass();

        $out = [
            $this->getPathType() => [
                $this->getPath() => $out ,
            ],
        ];

        return $out;
    }

    /**
     * Returns 'path' for nested and 'type' for parent inner hits
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
}
