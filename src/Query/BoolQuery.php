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
 * Represents Elasticsearch "bool" query.
 *
 * @link http://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-query.html
 */
class BoolQuery implements BuilderInterface
{
    use ParametersTrait;

    const MUST = 'must';
    const MUST_NOT = 'must_not';
    const SHOULD = 'should';

    /**
     * @var array
     */
    private $container;

    /**
     * Constructor to prepare container.
     */
    public function __construct()
    {
        $this->container = [];
    }

    /**
     * Checks if bool expression is relevant.
     *
     * @return bool
     *
     * @deprecated Will be removed in 2.0. No replacement. Always use full structure.
     */
    public function isRelevant()
    {
        return true;
    }

    /**
     * @param  null $boolType
     * @return array
     */
    public function getQueries($boolType = null)
    {
        if ($boolType === null) {
            $queries = [];

            foreach ($this->container as $item) {
                $queries = array_merge($queries, $item);
            }

            return $queries;
        }

        return $this->container[$boolType];
    }

    /**
     * Add BuilderInterface object to bool operator.
     *
     * @param BuilderInterface $query Query add to the bool.
     * @param string           $type  Bool type. Example: must, must_not, should.
     * @param string           $key   Key that indicates a builder id.
     *
     * @return string Key of added builder.
     *
     * @throws \UnexpectedValueException
     */
    public function add(BuilderInterface $query, $type = self::MUST, $key = null)
    {
        if (!in_array($type, (new \ReflectionObject($this))->getConstants())) {
            throw new \UnexpectedValueException(sprintf('The bool operator %s is not supported', $type));
        }

        if (!$key) {
            $key = uniqid();
        }

        $this->container[$type][$key] = $query;

        return $key;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = [];

        foreach ($this->container as $boolType => $builders) {
            /** @var BuilderInterface $builder */
            foreach ($builders as $builder) {
                $output[$boolType][] = [$builder->getType() => $builder->toArray()];
            }
        }

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'bool';
    }
}
