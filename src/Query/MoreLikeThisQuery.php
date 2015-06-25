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
 * Elasticsearch more_like_this query class.
 */
class MoreLikeThisQuery implements BuilderInterface
{
    use ParametersTrait;

    /**
     * @var string The text to find documents like it, required if ids or docs are not specified.
     */
    private $likeText;

    /**
     * @param string $likeText
     * @param array  $parameters
     */
    public function __construct($likeText, array $parameters = [])
    {
        $this->likeText = $likeText;
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'more_like_this';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $query = [];

        if (($this->hasParameter('ids') === false) || ($this->hasParameter('docs') === false)) {
            $query['like_text'] = $this->likeText;
        }

        $output = $this->processArray($query);

        return $output;
    }
}
