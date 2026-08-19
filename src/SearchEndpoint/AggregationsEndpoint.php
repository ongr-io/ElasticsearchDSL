<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\SearchEndpoint;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AggregationsEndpoint extends AbstractSearchEndpoint
{
    public const NAME = 'aggregations';

    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = [])
    {
        $output = [];
        if (count($this->getAll()) > 0) {
            /** @var AbstractAggregation $aggregation */
            foreach ($this->getAll() as $aggregation) {
                $output[$aggregation->getName()] = $aggregation->toArray();
            }
        }

        return $output;
    }
}
