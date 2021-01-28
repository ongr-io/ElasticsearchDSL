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

namespace ONGR\ElasticsearchDSL\Sort;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;
use stdClass;

class FieldSort implements BuilderInterface
{
    use ParametersTrait;

    public const ASC = 'asc';

    public const DESC = 'desc';

    private ?BuilderInterface $nestedFilter = null;

    public function __construct(private string $field, private mixed $order = null, $params = [])
    {
        $this->setParameters($params);
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(string $field): static
    {
        $this->field = $field;

        return $this;
    }

    public function getOrder(): mixed
    {
        return $this->order;
    }

    public function setOrder(mixed $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getNestedFilter(): ?BuilderInterface
    {
        return $this->nestedFilter;
    }

    public function setNestedFilter(?BuilderInterface $nestedFilter): static
    {
        $this->nestedFilter = $nestedFilter;

        return $this;
    }

    public function getType(): string
    {
        return 'sort';
    }

    public function toArray(): array
    {
        if ($this->order) {
            $this->addParameter('order', $this->order);
        }

        if ($this->nestedFilter) {
            $this->addParameter('nested', $this->nestedFilter->toArray());
        }

        $output = [
            $this->field => $this->getParameters() ?: new stdClass(),
        ];

        return $output;
    }
}
