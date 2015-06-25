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
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "ids" filter.
 */
class IdsFilter implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string[]
     */
    private $values;

    /**
     * @param string[] $values     Ids' values.
     * @param array    $parameters Optional parameters.
     */
    public function __construct($values, array $parameters = [])
    {
        $this->values = $values;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'ids';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [];
        $query['values'] = $this->values;

        $output = $this->processArray($query);

        return $output;
    }
}
