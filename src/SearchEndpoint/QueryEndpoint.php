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
    use ParametersTrait;

    /**
     * @var OptionsResolver
     */
    private $resolver;

    /**
     * Instantiates resolver.
     */
    public function __construct()
    {
        $this->resolver = new OptionsResolver();
        $this->configureResolver($this->resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        if ($this->hasReference('filtered_query')) {
            /** @var FilteredQuery $query */
            $query = $this->getReference('filtered_query');
            $this->addBuilder($query);
        }

        $builder = $this->getBuilderForNormalization();

        if (empty($builder)) {
            return null;
        }

        return [$builder->getType() => $builder->toArray()];
    }

    /**
     * Return builder that is ready to be normalized.
     *
     * @return BuilderInterface|null
     */
    protected function getBuilderForNormalization()
    {
        $builders = $this->getbuilders();
        if (empty($builders)) {
            return null;
        }

        if (count($builders) > 1) {
            $builder = $this->buildBool();
        } else {
            $builder = end($builders);
        }

        if (method_exists($builder, 'setParameters') && count($this->getParameters()) > 0) {
            $builder->setParameters($this->processArray($builder->getParameters()));
        }

        return $builder;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * Default properties for query.
     *
     * @param OptionsResolver $resolver
     */
    protected function configureResolver(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(
                ['bool_type' => BoolQuery::MUST]
            );
    }

    /**
     * Returns bool instance for this endpoint case.
     *
     * @return BoolFilter|BoolQuery
     */
    protected function getBoolInstance()
    {
        return new BoolQuery();
    }

    /**
     * Returns bool instance with builders set.
     *
     * @return BoolFilter|BoolQuery
     */
    protected function buildBool()
    {
        $boolInstance = $this->getBoolInstance();

        foreach ($this->getBuilders() as $key => $builder) {
            $parameters = $this->resolver->resolve(array_filter($this->getBuilderParameters($key)));
            $boolInstance->add($builder, $parameters['bool_type']);
        }

        return $boolInstance;
    }
}
