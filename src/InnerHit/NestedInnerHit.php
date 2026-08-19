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

namespace ONGR\ElasticsearchDSL\InnerHit;

use ONGR\ElasticsearchDSL\NameAwareTrait;
use ONGR\ElasticsearchDSL\NamedBuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;
use ONGR\ElasticsearchDSL\Search;
use stdClass;

/**
 * Represents Elasticsearch top level nested inner hits.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-inner-hits.html
 */
class NestedInnerHit implements NamedBuilderInterface
{
    use ParametersTrait;

    use NameAwareTrait;

    public function __construct(?string $name = null, private ?string $path = null, private ?Search $search = null)
    {
        $this->setName($name);
        $this->setPath($path);
        if ($search) {
            $this->setSearch($search);
        }
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getSearch(): ?Search
    {
        return $this->search;
    }

    public function setSearch(Search $search): static
    {
        $this->search = $search;

        return $this;
    }

    public function getType(): string
    {
        return 'nested';
    }

    public function toArray(): array
    {
        $out = new stdClass();

        if (null !== $this->getSearch()) {
            $out = $this->getSearch()->toArray();
        }

        return [
            $this->getPathType() => [
                $this->getPath() => $out,
            ],
        ];
    }

    private function getPathType(): ?string
    {
        return match ($this->getType()) {
            'nested' => 'path',
            'parent' => 'type',
            default => null
        };
    }
}
