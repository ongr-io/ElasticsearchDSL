<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query\Compound;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "bool" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-query.html
 */
class BoolQuery implements BuilderInterface
{
    use ParametersTrait;

    const MUST = 'must';
    const MUST_NOT = 'must_not';
    const SHOULD = 'should';
    const FILTER = 'filter';

    /**
     * @var array
     */
    private $container = [];

    /**
     * Constructor to prepare container.
     */
    public function __construct()
    {
        $this->container = [];
    }

    /**
     * Returns the query instances (by bool type).
     *
     * @param  string|null $boolType
     *
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

        if (isset($this->container[$boolType])) {
            return $this->container[$boolType];
        }

        return [];
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
        if (!in_array($type, [self::MUST, self::MUST_NOT, self::SHOULD, self::FILTER])) {
            throw new \UnexpectedValueException(sprintf('The bool operator %s is not supported', $type));
        }

        if (!$key) {
            $key = bin2hex(random_bytes(30));
        }

        $this->container[$type][$key] = $query;

        return $key;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        if (count($this->container) === 1 && isset($this->container[self::MUST])
                && count($this->container[self::MUST]) === 1) {
            $query = reset($this->container[self::MUST]);

            return $query->toArray();
        }

        $output = [];

        foreach ($this->container as $boolType => $builders) {
            /** @var BuilderInterface $builder */
            foreach ($builders as $builder) {
                $output[$boolType][] = $builder->toArray();
            }
        }

        $output = $this->processArray($output);

        if (empty($output)) {
            $output = new \stdClass();
        }

        return [$this->getType() => $output];
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'bool';
    }
}
