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
 * Regexp query class.
 */
class RegexpQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * Field to be queried.
     *
     * @var string
     */
    private $field;

    /**
     * The actual regexp value to be used.
     *
     * @var string
     */
    private $regexpValue;

    /**
     * @param string $field
     * @param string $regexpValue
     * @param array  $parameters
     */
    public function __construct($field, $regexpValue, array $parameters = [])
    {
        $this->field = $field;
        $this->regexpValue = $regexpValue;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'regexp';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            'value' => $this->regexpValue,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return $output;
    }
}
