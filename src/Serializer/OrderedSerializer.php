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

namespace ONGR\ElasticsearchDSL\Serializer;

use ONGR\ElasticsearchDSL\Serializer\Normalizer\OrderedNormalizerInterface;
use Symfony\Component\Serializer\Serializer;

class OrderedSerializer extends Serializer
{
    /**
     * {@inheritdoc}
     */
    public function normalize(mixed $data, string $format = null, array $context = []): mixed
    {
        return parent::normalize(
            is_array($data) ? $this->order($data) : $data,
            $format,
            $context
        );
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        return parent::denormalize(
            is_array($data) ? $this->order($data) : $data,
            $type,
            $format,
            $context
        );
    }

    private function order(array $data): array
    {
        $filteredData = $this->filterOrderable($data);

        if (!empty($filteredData)) {
            uasort(
                $filteredData,
                function (OrderedNormalizerInterface $a, OrderedNormalizerInterface $b) {
                    return $a->getOrder() > $b->getOrder();
                }
            );

            return array_merge($filteredData, array_diff_key($data, $filteredData));
        }

        return $data;
    }

    private function filterOrderable(array $array): array
    {
        return array_filter(
            $array,
            function ($value) {
                return $value instanceof OrderedNormalizerInterface;
            }
        );
    }
}
