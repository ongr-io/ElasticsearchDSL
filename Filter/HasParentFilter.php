<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Filter;

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;
use ONGR\ElasticsearchBundle\DSL\ParametersTrait;

/**
 * Elasticsearch has_parent filter.
 */
class HasParentFilter implements BuilderInterface
{
    use ParametersTrait;

    const INNER_QUERY = 'query';
    const INNER_FILTER = 'filter';

    /**
     * @var string
     */
    private $parentType;

    /**
     * @var BuilderInterface
     */
    private $filter;

    /**
     * @var BuilderInterface
     */
    private $query;

    /**
     * @param string           $parentType
     * @param BuilderInterface $block
     * @param array            $parameters
     * @param string           $inner
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        $parentType,
        BuilderInterface $block,
        array $parameters = [],
        $inner = self::INNER_FILTER
    ) {
        $this->parentType = $parentType;

        switch ($inner) {
            case 'filter':
                $this->filter = $block;
                break;
            case 'query':
                $this->query = $block;
                break;
            default:
                throw new \InvalidArgumentException('Not supported argument type');
        }

        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'has_parent';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [ 'parent_type' => $this->parentType ];

        $queries = ['filter', 'query'];

        foreach ($queries as $type) {
            if ($this->{$type}) {
                $query[$type] = [
                    $this->{$type}->getType() => $this->{$type}->toArray(),
                ];
            }
        }

        $output = $this->processArray($query);

        return $output;
    }
}
