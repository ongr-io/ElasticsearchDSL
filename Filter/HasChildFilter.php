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
 * Elasticsearch has_child filter.
 */
class HasChildFilter implements BuilderInterface
{
    use ParametersTrait;

    const INNER_QUERY = 'query';
    const INNER_FILTER = 'filter';

    /**
     * @var string
     */
    private $type;

    /**
     * @var BuilderInterface
     */
    private $filter;

    /**
     * @var BuilderInterface
     */
    private $query;

    /**
     * @param string           $type
     * @param BuilderInterface $block
     * @param array            $parameters
     * @param string           $inner
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($type, BuilderInterface $block, array $parameters = [], $inner = self::INNER_FILTER)
    {
        $this->type = $type;

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
        return 'has_child';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [ 'type' => $this->type ];

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
