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

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;

/**
 * Abstract class for sorting.
 */
abstract class AbstractSort implements BuilderInterface
{
    /**
     * @const ORDER_ASC Sort in ascending order.
     */
    const ORDER_ASC = 'asc';

    /**
     * @const ORDER_DESC Sort in descending order.
     */
    const ORDER_DESC = 'desc';

    /**
     * @const MODE_MIN Pick the lowest value in multi-valued field.
     */
    const MODE_MIN = 'min';

    /**
     * @const MODE_MAX Pick the highest value in multi-valued field.
     */
    const MODE_MAX = 'max';

    /**
     * @const MODE_AVG Use the sum of all values as sort value. Only applicable for number based array fields.
     */
    const MODE_AVG = 'avg';

    /**
     * @const MODE_SUM Use the average of all values as sort value. Only applicable for number based array fields.
     */
    const MODE_SUM = 'sum';

    /**
     * @var string
     */
    private $order = self::ORDER_ASC;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var string
     */
    private $field;

    /**
     * @param string $field Field name.
     * @param string $order Order direction.
     * @param string $mode  Multi-valued field sorting mode [MODE_MIN, MODE_MAX, MODE_AVG, MODE_SUM].
     */
    public function __construct($field, $order, $mode)
    {
        $this->setField($field);
        $this->setOrder($order);
        $this->setMode($mode);
    }

    /**
     * Set multi-valued field sorting mode [MODE_MIN, MODE_MAX, MODE_AVG, MODE_SUM].
     *
     * @param string $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * Returns mode.
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set order direction.
     *
     * @param string|array $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    abstract public function getType();

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $value = [];

        if ($this->getOrder()) {
            $value['order'] = $this->getOrder();
        }

        if ($this->getMode() !== null) {
            $value['mode'] = $this->getMode();
        }

        return $value;
    }
}
