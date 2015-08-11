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

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Filter\BoolFilter;
use ONGR\ElasticsearchDSL\ParametersTrait;
use ONGR\ElasticsearchDSL\Query\BoolQuery;
use ONGR\ElasticsearchDSL\Query\FilteredQuery;
use ONGR\ElasticsearchDSL\Serializer\Normalizer\OrderedNormalizerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search query dsl endpoint.
 */
class QueryEndpoint extends AbstractSearchEndpoint implements OrderedNormalizerInterface
{
    /**
     * Endpoint name
     */
    const NAME = 'query';

    /**
     * @var BoolQuery
     */
    private $bool;

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        if ($this->hasReference('filtered_query')) {
            /** @var FilteredQuery $filteredQuery */
            $filteredQuery = $this->getReference('filtered_query');
            $this->add($filteredQuery);
        }

        if (!$this->bool) {
            return null;
        }

        $queryArray = $this->bool->toArray();

        if ($this->bool->isRelevant()) {
            $queryArray = [$this->bool->getType() => $queryArray];
        }

        return $queryArray;
    }

    /**
     * {@inheritdoc}
     */
    public function add(BuilderInterface $builder, $key = null)
    {
        return $this->addToBool($builder, BoolQuery::MUST, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function addToBool(BuilderInterface $builder, $boolType = null, $key = null)
    {
        if (!$this->bool) {
            $this->bool = $this->getBoolInstance();
        }

        return $this->bool->add($builder, $boolType, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * @return BoolQuery
     */
    public function getBool()
    {
        return $this->bool;
    }

    /**
     * Returns new bool instance for the endpoint.
     *
     * @return BoolQuery
     */
    protected function getBoolInstance()
    {
        return new BoolQuery();
    }

    /**
     * {@inheritdoc}
     */
    public function getAll($boolType = null)
    {
        return $this->bool->getQueries($boolType);
    }
}
