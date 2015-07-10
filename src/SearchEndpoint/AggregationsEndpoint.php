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
use ONGR\ElasticsearchDSL\NamedBuilderBag;
use ONGR\ElasticsearchDSL\NamedBuilderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search aggregations dsl endpoint.
 */
class AggregationsEndpoint implements SearchEndpointInterface
{
    use BuilderContainerAwareTrait;

    /**
     * @var NamedBuilderBag
     */
    private $bag;

    /**
     * Initialized aggregations bag.
     */
    public function __construct()
    {
        $this->bag = new NamedBuilderBag();
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        if (count($this->bag->all()) > 0) {
            return $this->bag->toArray();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function addBuilder(BuilderInterface $builder, $parameters = [])
    {
        if (!($builder instanceof NamedBuilderInterface)) {
            throw new \InvalidArgumentException('Builder must be named builder');
        }

        $this->bag->add($builder);

        return $builder->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getBuilders()
    {
        return $this->bag->all();
    }

    /**
     * {@inheritdoc}
     */
    public function getBuilder($key)
    {
        if (!$this->bag->has($key)) {
            return null;
        }

        return $this->bag->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function removeBuilder($key)
    {
        $this->bag->remove($key);

        return $this;
    }
}
