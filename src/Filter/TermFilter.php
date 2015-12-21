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

@trigger_error(
    'The TermFilter class is deprecated and will be removed in 2.0. Use TermQuery instead.',
    E_USER_DEPRECATED
);

use ONGR\ElasticsearchDSL\Query\TermQuery;

/**
 * Represents Elasticsearch "term" filter.
 *
 * @deprecated Will be removed in 2.0. Use the TermQuery instead.
 */
class TermFilter extends TermQuery
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
     * {@inheritdoc}
     */
    public function __construct($field, $value, array $parameters = [])
    {
        $this->field = $field;
        $this->value = $value;

        parent::__construct($field, $value, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [$this->field => $this->value];

        $output = $this->processArray($query);

        return $output;
    }
}
