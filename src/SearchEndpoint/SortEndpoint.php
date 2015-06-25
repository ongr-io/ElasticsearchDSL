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
use ONGR\ElasticsearchDSL\Sort\Sorts;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search sort dsl endpoint.
 */
class SortEndpoint implements SearchEndpointInterface
{
    /**
     * @var Sorts
     */
    protected $sorts;

    /**
     * Initializes Sorts object.
     */
    public function __construct()
    {
        $this->sorts = new Sorts();
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        if ($this->sorts->isRelevant()) {
            return $this->sorts->toArray();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addBuilder(BuilderInterface $builder, $parameters = [])
    {
        $this->sorts->addSort($builder);
    }

    /**
     * {@inheritdoc}
     */
    public function getBuilder()
    {
        return $this->sorts;
    }
}
