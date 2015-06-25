<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Filter;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\DslTypeAwareTrait;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Elasticsearch has_child filter.
 */
class HasChildFilter implements BuilderInterface
{
    use ParametersTrait;
    use DslTypeAwareTrait;

    /**
     * @var string
     */
    private $type;

    /**
     * @var BuilderInterface
     */
    private $query;

    /**
     * @param string           $type
     * @param BuilderInterface $query
     * @param array            $parameters
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($type, BuilderInterface $query, array $parameters = [])
    {
        $this->type = $type;
        $this->query = $query;
        $this->setParameters($parameters);
        $this->setDslType('filter');
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'has_child';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            'type' => $this->type,
            $this->getDslType() => [$this->query->getType() => $this->query->toArray()],
        ];

        $output = $this->processArray($query);

        return $output;
    }
}
