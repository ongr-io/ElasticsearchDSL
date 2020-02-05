<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query\TermLevel;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "terms_set" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-terms-set-query.html
 */
class TermsSetQuery implements BuilderInterface
{
    use ParametersTrait;

    const MINIMUM_SHOULD_MATCH_TYPE_FIELD = 'minimum_should_match_field';
    const MINIMUM_SHOULD_MATCH_TYPE_SCRIPT = 'minimum_should_match_script';

    /**
     * @var string
     */
    private $field;

    /**
     * @var array
     */
    private $terms;

    /**
     * Constructor.
     *
     * @param string $field      Field name
     * @param array  $terms      An array of terms
     * @param array  $parameters Parameters
     */
    public function __construct($field, $terms, array $parameters)
    {
        $this->field = $field;
        $this->terms = $terms;
        $this->validateParameters($parameters);
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'terms_set';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            'terms' => $this->terms,
        ];

        return [$this->getType() => [
            $this->field => $this->processArray($query),
        ]];
    }

    private function validateParameters(array $parameters)
    {
        if (!isset($parameters[self::MINIMUM_SHOULD_MATCH_TYPE_FIELD]) &&
            !isset($parameters[self::MINIMUM_SHOULD_MATCH_TYPE_SCRIPT])
        ) {
            $message = "Either minimum_should_match_field or minimum_should_match_script must be set.";
            throw new \InvalidArgumentException($message);
        }
    }
}
