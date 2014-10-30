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

/**
 * Represents Elasticsearch "exists" filter.
 */
class ExistsFilter implements BuilderInterface
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $field Field value.
     * @param string $value Field name.
     */
    public function __construct($field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'exists';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            $this->field => $this->value,
        ];
    }
}
