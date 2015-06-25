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
 * Represents Elasticsearch "indices" filter.
 */
class IndicesFilter implements BuilderInterface
{
    /**
     * @var string[]
     */
    private $indices;

    /**
     * @var BuilderInterface
     */
    private $filter;

    /**
     * @var string|BuilderInterface
     */
    private $noMatchFilter;

    /**
     * @param string[]         $indices
     * @param BuilderInterface $filter
     * @param BuilderInterface $noMatchFilter
     */
    public function __construct($indices, $filter, $noMatchFilter = null)
    {
        $this->indices = $indices;
        $this->filter = $filter;
        $this->noMatchFilter = $noMatchFilter;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'indices';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        if (count($this->indices) > 1) {
            $output = ['indices' => $this->indices];
        } else {
            $output = ['index' => $this->indices[0]];
        }

        $output['filter'] = [$this->filter->getType() => $this->filter->toArray()];

        if ($this->noMatchFilter !== null) {
            if (is_a($this->noMatchFilter, 'ONGR\ElasticsearchDSL\BuilderInterface')) {
                $output['no_match_filter'] = [$this->noMatchFilter->getType() => $this->noMatchFilter->toArray()];
            } else {
                $output['no_match_filter'] = $this->noMatchFilter;
            }
        }

        return $output;
    }
}
