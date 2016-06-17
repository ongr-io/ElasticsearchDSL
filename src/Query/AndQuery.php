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
use Symfony\Component\Serializer\Exception\InvalidArgumentException;

/**
 * Represents Elasticsearch "and" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-and-query.html
 */
class AndQuery implements BuilderInterface
{
    /**
     * @var array
     */
    private $queries;

    /**
     * @param array $queries
     */
    public function __construct(array $queries = [])
    {
        $this->queries = $queries;
    }

    /**
     * adds a query to join with AND operator
     *
     * @param BuilderInterface $query
     */
    public function addQuery(BuilderInterface $query)
    {
        $this->queries[] = $query;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'and';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = [];
        foreach ($this->queries as $query) {
            try {
                $output[] = $query->toArray();
            } catch (\Error $e) {
                throw new InvalidArgumentException(
                    'Queries given to `AND` query must be instances of BuilderInterface'
                );
            }
        }

        return [$this->getType() => $output];
    }
}
