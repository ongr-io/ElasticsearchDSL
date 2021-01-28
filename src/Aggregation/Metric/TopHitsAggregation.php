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

namespace ONGR\ElasticsearchDSL\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;
use ONGR\ElasticsearchDSL\BuilderInterface;
use stdClass;

/**
 * Top hits aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-top-hits-aggregation.html
 */
class TopHitsAggregation extends AbstractAggregation
{
    use MetricTrait;

    private array $sorts = [];

    public function __construct(
        private string $name,
        private ?int $size = null,
        private ?int $from = null,
        ?BuilderInterface $sort = null
    ) {
        parent::__construct($name);
        $this->setFrom($from);
        $this->setSize($size);
        $this->addSort($sort);
    }

    public function getFrom(): ?int
    {
        return $this->from;
    }

    public function setFrom(?int $from): static
    {
        $this->from = $from;

        return $this;
    }

    public function getSorts(): array
    {
        return $this->sorts;
    }

    public function setSorts(array $sorts): static
    {
        $this->sorts = $sorts;

        return $this;
    }

    public function addSort(?BuilderInterface $sort): void
    {
        $this->sorts[] = $sort;
    }

    public function setSize(?int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getType(): string
    {
        return 'top_hits';
    }

    public function getArray(): array|stdClass
    {
        $sortsOutput = null;
        $addedSorts = array_filter($this->getSorts());

        if ($addedSorts) {
            $sortsOutput = [];
            foreach ($addedSorts as $sort) {
                $sortsOutput[] = $sort->toArray();
            }
        }

        $output = array_filter(
            [
                'sort' => $sortsOutput,
                'size' => $this->getSize(),
                'from' => $this->getFrom(),
            ],
            fn(mixed $val): bool => (($val || is_array($val) || ($val || is_numeric($val))))
        );

        return $output ?? new stdClass();
    }

    public function getSort(): ?BuilderInterface
    {
        if (isset($this->sorts[0])) {
            return $this->sorts[0];
        }

        return null;
    }

    public function setSort(BuilderInterface $sort): static
    {
        $this->sort = $sort;

        return $this;
    }
}
