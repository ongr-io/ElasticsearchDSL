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
 * Elasticsearch match_all query class.
 */
class MatchAllQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @param array $parameters Additional parameters.
     */
    public function __construct(array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'match_all';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        if (count($this->getParameters()) > 0) {
            return $this->getParameters();
        }

        return new \stdClass();
    }
}
