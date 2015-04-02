<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\SearchEndpoint;

use ONGR\ElasticsearchBundle\DSL\Bool\Bool;
use ONGR\ElasticsearchBundle\DSL\BuilderInterface;
use ONGR\ElasticsearchBundle\DSL\ParametersTrait;
use ONGR\ElasticsearchBundle\DSL\Query\FilteredQuery;
use ONGR\ElasticsearchBundle\Serializer\Normalizer\OrderedNormalizerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search query dsl endpoint.
 */
class QueryEndpoint extends AbstractSearchEndpoint implements OrderedNormalizerInterface
{
    use ParametersTrait;

    /**
     * @var BuilderInterface|Bool
     */
    private $query;

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
    public function addBuilder(BuilderInterface $builder, $parameters = [])
    {
        if (!$this->query && !(array_key_exists('bool_type', $parameters) && !empty($parameters['bool_type']))) {
            $this->setBuilder($builder);
        } else {
            $parameters = $this->resolver->resolve(array_filter($parameters));
            $this->query instanceof Bool ? : $this->convertToBool();
            $this->query->addToBool($builder, $parameters['bool_type']);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        $isRelevant = false;

        if ($this->hasReference('filtered_query')) {
            /** @var FilteredQuery $query */
            $query = $this->getReference('filtered_query');
            $this->addBuilder($query);
            $isRelevant = true;
        }

        if ($this->getBuilder()) {
            if (method_exists($this->getBuilder(), 'setParameters') && count($this->getParameters()) > 0) {
                $this
                    ->getBuilder()
                    ->setParameters($this->processArray($this->getBuilder()->getParameters()));
            }

            $isRelevant = true;
        }

        return $isRelevant ? [$this->getBuilder()->getType() => $this->getBuilder()->toArray()] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * {@inheritdoc}
     */
    public function getBuilder()
    {
        return $this->query;
    }

    /**
     * Sets builder.
     *
     * @param BuilderInterface $builder
     */
    protected function setBuilder(BuilderInterface $builder)
    {
        $this->query = $builder;
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
                ['bool_type' => Bool::MUST]
            );
    }

    /**
     * Converts query to bool.
     */
    private function convertToBool()
    {
        $bool = new Bool();

        if ($this->query !== null) {
            $bool->addToBool($this->query);
        }

        $this->query = $bool;
    }
}
