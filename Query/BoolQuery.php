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

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;
use ONGR\ElasticsearchBundle\DSL\ParametersTrait;

/**
 * Represents Elasticsearch "bool" filter.
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
     * Checks if bool expression is relevant.
     *
     * @return bool
     */
    public function isRelevant()
    {
        return (bool)count($this->container);
    }

    /**
     * Add BuilderInterface object to bool operator.
     *
     * @param BuilderInterface $builder Query or a filter to add to bool.
     * @param string           $type    Bool type. Available: must, must_not, should.
     *
     * @return BoolQuery
     *
     * @throws \UnexpectedValueException
     */
    public function add(BuilderInterface $builder, $type = self::MUST)
    {
        if (!in_array($type, (new \ReflectionObject($this))->getConstants())) {
            throw new \UnexpectedValueException(sprintf('The bool operator %s is not supported', $type));
        }

        $this->container[$type][] = [$builder->getType() => $builder->toArray()];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->processArray($this->container);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'bool';
    }
}
