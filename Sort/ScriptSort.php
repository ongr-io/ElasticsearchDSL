<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Sort;

/**
 * Sort based on custom scripts.
 *
 * Note, it is recommended, for single custom based script based sorting, to use function_score query instead.
 * Sorting based on score is faster.
 */
class ScriptSort extends AbstractSort
{
    /**
     * Script to execute.
     *
     * @var string
     */
    private $script;

    /**
     * Type returned (number, string).
     *
     * @var string
     */
    private $returnType;

    /**
     * Associative array of custom params with values.
     *
     * Example: ['factor' => 1.5]
     *
     * @var array
     */
    private $params;

    /**
     * Initializes script sort.
     *
     * @param string $script
     * @param string $returnType
     * @param array  $params
     * @param string $order
     */
    public function __construct($script, $returnType, $params = null, $order = self::ORDER_DESC)
    {
        $this->setParams($params);
        $this->setScript($script);
        $this->setOrder($order);
        $this->setReturnType($returnType);
    }

    /**
     * @return string
     */
    public function getReturnType()
    {
        return $this->returnType;
    }

    /**
     * @param string $returnType
     */
    public function setReturnType($returnType)
    {
        $this->returnType = $returnType;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * @param string $script
     */
    public function setScript($script)
    {
        $this->script = $script;
    }

    /**
     * @return string
     */
    final public function getType()
    {
        return '_script';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $value = [];

        if ($this->getOrder()) {
            $value['order'] = $this->getOrder();
        }

        $value['script'] = $this->getScript();

        if ($this->getParams()) {
            $value['params'] = $this->getParams();
        }

        $value['type'] = $this->getReturnType();

        return $value;
    }
}
