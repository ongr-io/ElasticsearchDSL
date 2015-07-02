<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Elasticsearch nested query class.
 */
class NestedQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $path;

    /**
     * @var BuilderInterface
     */
    private $query;

    /**
     * @param string           $path
     * @param BuilderInterface $query
     */
    public function __construct($path, BuilderInterface $query)
    {
        $this->path = $path;
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
        return $this->processArray(
            [
                'path' => $this->path,
                'query' => [
                    $this->query->getType() => $this->query->toArray(),
                ],
            ]
        );
    }
}
