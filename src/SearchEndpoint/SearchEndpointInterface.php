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
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

/**
 * Interface used to define search endpoint.
 */
interface SearchEndpointInterface extends NormalizableInterface
{
    /**
     * Adds builder to search endpoint.
     *
     * @param BuilderInterface $builder    Builder to add.
     * @param array            $parameters Additional parameters relevant to builder.
     *
     * @return SearchEndpointInterface
     */
    public function addBuilder(BuilderInterface $builder, $parameters = []);

    /**
     * Returns contained builder.
     *
     * @return BuilderInterface|BuilderInterface[]
     */
    public function getBuilder();
}
