<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Query;

use ONGR\ElasticsearchBundle\DSL\Bool\Bool;
use ONGR\ElasticsearchBundle\DSL\BuilderInterface;

/**
 * Query class.
 */
class Query implements BuilderInterface
{
    /**
     * @var BuilderInterface[] Queries
     */
    private $queries;

    /**
     * @var NestedQuery
     */
    private $nested = null;

    /**
     * @param array $boolParams Possible values:
     *                          - disable_coord => true
     *                          - false
     *                          - minimum_should_match
     *                          - boost.
     */
    public function __construct($boolParams = [])
    {
        $this->queries = new Bool();
        $this->queries->setParameters($boolParams);
    }

    /**
     * @param BuilderInterface $query    Query.
     * @param string           $boolType Possible boolType values:
     *                                   - must
     *                                   - must_not
     *                                   - should.
     */
    public function addQuery(BuilderInterface $query, $boolType = 'must')
    {
        $this->queries->addToBool($query, $boolType);
    }

    /**
     * Overrides query.
     *
     * @param BuilderInterface $query
     */
    public function setQuery(BuilderInterface $query)
    {
        $this->queries = $query;
    }

    /**
     * @param array $boolParams Possible values:
     *                          - disable_coord => true
     *                          - false
     *                          - minimum_should_match
     *                          - boost.
     */
    public function setBoolParameters($boolParams)
    {
        $this->queries->setParameters($boolParams);
    }

    /**
     * @param string           $path
     * @param BuilderInterface $query
     */
    public function addToNested($path, $query)
    {
        $this->nested = new NestedQuery($path, $query);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'query';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = [
            $this->queries->getType() => $this->queries->toArray(),
        ];

        return $output;
    }
}
