<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query\Span;

use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Elasticsearch span containing query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-containing-query.html
 */
class SpanContainingQuery implements SpanQueryInterface
{
    use ParametersTrait;

    /**
     * @param SpanQueryInterface
     */
    private $little;

    /**
     * @param SpanQueryInterface
     */
    private $big;

    /**
     * @param SpanQueryInterface $little
     * @param SpanQueryInterface $big
     */
    public function __construct(SpanQueryInterface $little, SpanQueryInterface $big)
    {
        $this->setLittle($little);
        $this->setBig($big);
    }

    /**
     * @return SpanQueryInterface
     */
    public function getLittle()
    {
        return $this->little;
    }

    /**
     * @param SpanQueryInterface $little
     */
    public function setLittle(SpanQueryInterface $little)
    {
        $this->little = $little;
    }

    /**
     * @return SpanQueryInterface
     */
    public function getBig()
    {
        return $this->big;
    }

    /**
     * @param SpanQueryInterface $big
     */
    public function setBig(SpanQueryInterface $big)
    {
        $this->big = $big;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'span_containing';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = [
            'little' => $this->getLittle()->toArray(),
            'big' => $this->getBig()->toArray(),
        ];

        $output = $this->processArray($output);

        return [$this->getType() => $output];
    }
}
