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

namespace ONGR\ElasticsearchDSL\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;
use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Class representing adjacency matrix aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-adjacency-matrix-aggregation.html
 */
class AdjacencyMatrixAggregation extends AbstractAggregation
{
    const FILTERS = 'filters';

    use BucketingTrait;

    private array $filters = [
        self::FILTERS => []
    ];

    public function __construct(string $name, array $filters = [])
    {
        parent::__construct($name);

        foreach ($filters as $name => $filter) {
            $this->addFilter($name, $filter);
        }
    }

    /**
     * @throws \LogicException
     */
    public function addFilter(string $name, BuilderInterface $filter): static
    {
        $this->filters[self::FILTERS][$name] = $filter->toArray();

        return $this;
    }

    public function getArray(): array
    {
        return $this->filters;
    }

    public function getType(): string
    {
        return 'adjacency_matrix';
    }
}
