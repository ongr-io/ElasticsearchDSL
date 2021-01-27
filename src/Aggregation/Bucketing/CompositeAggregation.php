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
 * Class representing composite aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-composite-aggregation.html
 */
class CompositeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    private ?int $size = null;

    private array $after = [];

    public function __construct(private string $name, private array $sources = [])
    {
        parent::__construct($name);

        foreach ($sources as $agg) {
            $this->addSource($agg);
        }
    }

    public function addSource(AbstractAggregation $agg): static
    {
        $array = $agg->getArray();

        $array = is_array($array) ? array_merge($array, $agg->getParameters()) : $array;

        $this->sources[] = [
            $agg->getName() => [ $agg->getType() => $array ]
        ];

        return $this;
    }

    public function getArray(): array
    {
        $array = [
            'sources' => $this->sources,
        ];

        if ($this->size !== null) {
            $array['size'] = $this->size;
        }

        if (!empty($this->after)) {
            $array['after'] = $this->after;
        }

        return $array;
    }

    public function getType(): string
    {
        return 'composite';
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

    public function setAfter(array $after): static
    {
        $this->after = $after;

        return $this;
    }

    public function getAfter(): array
    {
        return $this->after;
    }
}
