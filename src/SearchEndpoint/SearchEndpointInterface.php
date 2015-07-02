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
     * @return int Returns builder key.
     */
    public function addBuilder(BuilderInterface $builder, $parameters = []);

    /**
     * Removes contained builder.
     *
     * @param int $key
     *
     * @return $this
     */
    public function removeBuilder($key);

    /**
     * Returns contained builder or null if Builder is not found.
     *
     * @param int $key
     *
     * @return BuilderInterface|null
     */
    public function getBuilder($key);

    /**
     * Returns all contained builders.
     *
     * @return BuilderInterface[]
     */
    public function getBuilders();

    /**
     * Returns parameters for contained builder or empty array if parameters are not found.
     *
     * @param int $key
     *
     * @return array
     */
    public function getBuilderParameters($key);

    /**
     * @param int   $key
     * @param array $parameters
     *
     * @return $this
     */
    public function setBuilderParameters($key, $parameters);
}
