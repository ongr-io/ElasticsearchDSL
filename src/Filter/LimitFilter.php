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

/**
 * Represents Elasticsearch "limit" filter.
 *
 * A limit filter limits the number of documents (per shard) to execute on.
 */
class LimitFilter implements BuilderInterface
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value Number of documents (per shard) to execute on.
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'limit';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'value' => $this->value,
        ];
    }
}
