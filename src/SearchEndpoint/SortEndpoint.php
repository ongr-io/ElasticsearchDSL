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
use ONGR\ElasticsearchDSL\Sort\AbstractSort;
use ONGR\ElasticsearchDSL\Sort\Sorts;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search sort dsl endpoint.
 */
class SortEndpoint implements SearchEndpointInterface
{
    use BuilderContainerAwareTrait {
        addBuilder as private traitAddBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        $sorts = $this->buildSorts();

        if ($sorts->isRelevant()) {
            return $sorts->toArray();
        }

        return null;
    }

    /**
     * Builds sorts object.
     *
     * @return Sorts
     */
    protected function buildSorts()
    {
        $sorts = new Sorts();
        /** @var AbstractSort $builder */
        foreach ($this->getBuilders() as $builder) {
            $sorts->addSort($builder);
        }

        return $sorts;
    }

    /**
     * {@inheritdoc}
     */
    public function addBuilder(BuilderInterface $builder, $parameters = [])
    {
        if (!($builder instanceof AbstractSort)) {
            throw new \InvalidArgumentException('Sort must must a subtype of AbstractSort');
        }

        return $this->traitAddBuilder($builder, $parameters);
    }
}
