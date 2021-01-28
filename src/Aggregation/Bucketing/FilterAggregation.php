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
 * Class representing FilterAggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-filter-aggregation.html
 */
class FilterAggregation extends AbstractAggregation
{
    use BucketingTrait;

    public function __construct(
        private string $name,
        private ?BuilderInterface $filter = null
    ) {
        parent::__construct($name);
    }

    public function setFilter(BuilderInterface $filter): static
    {
        $this->filter = $filter;

        return $this;
    }

    public function getFilter(): BuilderInterface
    {
        return $this->filter;
    }

    public function setField($field): static
    {
        throw new \LogicException("Filter aggregation, doesn't support `field` parameter");
    }

    public function getArray(): array
    {
        if (!$this->filter) {
            throw new \LogicException("Filter aggregation `{$this->getName()}` has no filter added");
        }

        return $this->getFilter()->toArray();
    }

    public function getType(): string
    {
        return 'filter';
    }
}
