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
 * Constant score query class.
 */
class ConstantScoreQuery implements BuilderInterface
{
    use ParametersTrait;

    const USE_QUERY = 'query';
    const USE_FILTER = 'filter';

    /**
     * @var string
     */
    private $dslType;

    /**
     * @var BuilderInterface
     */
    private $query;

    /**
     * @param BuilderInterface $query
     * @param array            $parameters
     * @param string           $dslType
     */
    public function __construct(BuilderInterface $query, array $parameters = [], $dslType = self::USE_QUERY)
    {
        $this->dslType = $dslType;
        $this->query = $query;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'constant_score';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            strtolower($this->dslType) => [
                $this->query->getType() => $this->query->toArray(),
            ],
        ];

        $output = $this->processArray($query);

        return $output;
    }
}
