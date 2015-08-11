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
    private $container = [];

    /**
     * Constructor to prepare container.
     */
    public function __construct()
    {
        $this->container = [
            self::MUST => [],
            self::MUST_NOT => [],
            self::SHOULD => [],
        ];
    }

    /**
     * Checks if bool expression is relevant.
     *
     * @return bool
     */
    public function isRelevant()
    {
        return
            (count($this->container[self::MUST_NOT]) + count($this->container[self::SHOULD])) > 0
            || count($this->container[self::MUST]) > 1;
    }

    /**
     * @param  null $boolType
     * @return array
     */
    public function getQueries($boolType = null)
    {
        if ($boolType === null) {
            return array_merge(
                $this->container[self::MUST],
                $this->container[self::MUST_NOT],
                $this->container[self::SHOULD]
            );
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
        $output = $this->processArray();

        if (!$this->isRelevant()) {
            /** @var BuilderInterface $query */
            $mustContainer = $this->container[self::MUST];
            $query = array_shift($mustContainer);

            return [$query->getType() => $query->toArray()];
        }

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
