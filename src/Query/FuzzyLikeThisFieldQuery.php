<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Elasticsearch fuzzy_like_this_field query class.
 */
class FuzzyLikeThisFieldQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $likeText;

    /**
     * @param string $field
     * @param string $likeText
     * @param array  $parameters
     */
    public function __construct($field, $likeText, array $parameters = [])
    {
        $this->field = $field;
        $this->likeText = $likeText;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'fuzzy_like_this_field';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [
            'like_text' => $this->likeText,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return $output;
    }
}
