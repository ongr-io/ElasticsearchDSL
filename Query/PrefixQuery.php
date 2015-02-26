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
 * Represents Elasticsearch "prefix" query.
 */
class PrefixQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $field      Field name.
     * @param string $value      Value.
     * @param array  $parameters Optional parameters.
     */
    public function __construct($field, $value, array $parameters = [])
    {
        $this->field = $field;
        $this->value = $value;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'prefix';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            'value' => $this->value,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return $output;
    }
}
