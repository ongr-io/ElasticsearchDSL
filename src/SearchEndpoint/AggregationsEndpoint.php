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

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;
use ONGR\ElasticsearchBundle\DSL\NamedBuilderBag;
use ONGR\ElasticsearchBundle\DSL\NamedBuilderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search aggregations dsl endpoint.
 */
class AggregationsEndpoint implements SearchEndpointInterface
{
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
    }

    /**
     * {@inheritdoc}
     */
    public function addBuilder(BuilderInterface $builder, $parameters = [])
    {
        if ($builder instanceof NamedBuilderInterface) {
            $this->bag->add($builder);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBuilder()
    {
        return $this->bag->all();
    }
}
