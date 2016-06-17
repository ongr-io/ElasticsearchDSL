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

/**
 * Represents Elasticsearch "not" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-not-query.html
 */
class NotQuery implements BuilderInterface
{
    /**
     * @var array
     */
    private $query;

    /**
     * @param BuilderInterface $query
     */
    public function __construct(BuilderInterface $query)
    {
        $this->query = $query;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'not';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = [$this->getType() => $this->query->toArray()];

        return $output;
    }
}
