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
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        $builder = $this->getBuilderForNormalization();
        if (empty($builder)) {
            return;
        }

        $query = new FilteredQuery();
        $query->setFilter($builder);
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
     * {@inheritdoc}
     */
    protected function getBoolInstance()
    {
        return new BoolFilter();
    }
}
