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

/**
 * Represents Elasticsearch "template" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-template-query.html
 */
class TemplateQuery implements BuilderInterface
{
    /**
     * @var string
     */
    private $inline;

    /**
     * @var array
     */
    private $params;

    /**
     * @param string $inline A template of the query
     * @param array  $params Parameters to insert into template
     */
    public function __construct($inline, array $params)
    {
        $this->inline = $inline;
        $this->params = $params;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'template';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = [
            'inline' => $this->inline,
            'params' => $this->params,
        ];

        return [$this->getType() => $output];
    }
}
