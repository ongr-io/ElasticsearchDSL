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
 * Represents Elasticsearch "script" filter.
 *
 * Allows to define scripts as filters.
 */
class ScriptFilter implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $script;

    /**
     * @param string $script     Script.
     * @param array  $parameters Optional parameters.
     */
    public function __construct($script, array $parameters = [])
    {
        $this->script = $script;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'script';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = ['script' => $this->script];

        $output = $this->processArray($query);

        return $output;
    }
}
