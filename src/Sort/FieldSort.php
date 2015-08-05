<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Sort;

use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Holds all the values required for basic sorting.
 */
class FieldSort implements BuilderInterface
{
    CONST ASC = 'asc';
    CONST DESC = 'desc';

    /**
     * @var string.
     */
    private $field;

    /**
     * @var array
     */
    private $params;

    /**
     * @var BuilderInterface
     */
    private $nestedFilter;

    /**
     * @param string    $field  Field name.
     * @param array     $params Params that can be set to field sort.
     */
    public function __construct($field, $params = [])
    {
        $this->field = $field;
        $this->params = $params;
    }

    /**
     * @return BuilderInterface
     */
    public function getNestedFilter()
    {
        return $this->nestedFilter;
    }

    /**
     * @param BuilderInterface $nestedFilter
     */
    public function setNestedFilter(BuilderInterface $nestedFilter)
    {
        $this->nestedFilter = $nestedFilter;
    }

    /**
     * Returns element type.
     *
     * @return string
     */
    public function getType()
    {
        return 'sort';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        if ($this->nestedFilter) {
            $fieldValues = array_merge(
                $this->params,
                ['nested_filter' => [
                    $this->nestedFilter->getType() => $this->nestedFilter->toArray(),
                    ]
                ]
            );
        } else {
            $fieldValues = $this->params;
        }

        $output = [
            $this->field => $fieldValues,
        ];

        return $output;
    }
}
