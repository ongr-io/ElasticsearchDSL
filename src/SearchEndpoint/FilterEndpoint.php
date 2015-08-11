<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\SearchEndpoint;

use ONGR\ElasticsearchDSL\Filter\BoolFilter;
use ONGR\ElasticsearchDSL\Query\FilteredQuery;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search filter dsl endpoint.
 */
class FilterEndpoint extends QueryEndpoint
{
    /**
     * Endpoint name
     */
    const NAME = 'filter';

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        if (!$this->getBool()) {
            return null;
        }

        $query = new FilteredQuery();
        if (!$this->getBool()->isRelevant()) {
            $filters = $this->getBool()->getQueries(BoolFilter::MUST);
            $filter = array_shift($filters);
        } else {
            $filter = $this->getBool();
        }

        $query->setFilter($filter);
        $this->addReference('filtered_query', $query);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * Returns bool instance for this endpoint case.
     *
     * @return BoolFilter
     */
    protected function getBoolInstance()
    {
        return new BoolFilter();
    }
}
