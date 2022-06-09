<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Serializer;

use ONGR\ElasticsearchDSL\Serializer\Normalizer\OrderedNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerAwareTrait;

/**
 * Custom serializer which orders data before normalization.
 */
class OrderedSerializer implements NormalizerInterface, DenormalizerInterface
{
    /**
     * @param array<NormalizerInterface|DenormalizerInterface> $normalizers
     */
    public function __construct(array $normalizers = [])
    {
        $this->serializer = new Serializer($normalizers);
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return $this->serializer->normalize(
            is_array($object) ? $this->order($object) : $object,
            $format,
            $context
        );
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return $this->serializer->denormalize(
            is_array($data) ? $this->order($data) : $data,
            $type,
            $format,
            $context
        );
    }

    /**
     * Orders objects if can be done.
     *
     * @param array $data Data to order.
     *
     * @return array
     */
    private function order(array $data)
    {
        $filteredData = $this->filterOrderable($data);

        if (!empty($filteredData)) {
            uasort(
                $filteredData,
                function (OrderedNormalizerInterface $a, OrderedNormalizerInterface $b) {
                    return $a->getOrder() <=> $b->getOrder();
                }
            );

            return array_merge($filteredData, array_diff_key($data, $filteredData));
        }

        return $data;
    }

    /**
     * Filters out data which can be ordered.
     *
     * @param array $array Data to filter out.
     *
     * @return array
     */
    private function filterOrderable($array)
    {
        return array_filter(
            $array,
            function ($value) {
                return $value instanceof OrderedNormalizerInterface;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, string $format = null)
    {
        return $this->serializer->supportsNormalization($data, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $this->serializer->supportsDenormalization($data, $type, $format);
    }
}
