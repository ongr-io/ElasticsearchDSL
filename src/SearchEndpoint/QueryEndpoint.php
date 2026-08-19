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

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Serializer\Normalizer\OrderedNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class QueryEndpoint extends AbstractSearchEndpoint implements OrderedNormalizerInterface
{
    public const NAME = 'query';

    private ?BoolQuery $bool = null;

    private bool $filtersSet = false;

    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = [])
    {
        if (!$this->filtersSet && $this->hasReference('filter_query')) {
            /** @var BuilderInterface $filter */
            $filter = $this->getReference('filter_query');
            $this->addToBool($filter, BoolQuery::FILTER);
            $this->filtersSet = true;
        }

        if (!$this->bool) {
            return null;
        }

        return $this->bool->toArray();
    }

    public function add(BuilderInterface $builder, string $key = null): string
    {
        return $this->addToBool($builder, BoolQuery::MUST, $key);
    }

    public function addToBool(BuilderInterface $builder, ?string $boolType = null, ?string $key = null): string
    {
        if (!$this->bool) {
            $this->bool = new BoolQuery();
        }

        return $this->bool->add($builder, $boolType, $key);
    }

    public function getOrder(): int
    {
        return 2;
    }

    public function getBool(): ?BoolQuery
    {
        return $this->bool;
    }

    public function getAll($boolType = null): array
    {
        return $this->bool->getQueries($boolType);
    }
}
