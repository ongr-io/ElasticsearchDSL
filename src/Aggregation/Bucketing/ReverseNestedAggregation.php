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
use stdClass;

/**
 * Class representing ReverseNestedAggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-reverse-nested-aggregation.html
 */
class ReverseNestedAggregation extends AbstractAggregation
{
    use BucketingTrait;

    public function __construct(private string $name, private ?string $path = null)
    {
        parent::__construct($name);

        $this->setPath($path);
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

    public function getType(): string
    {
        return 'reverse_nested';
    }

    public function getArray(): stdClass|array
    {
        $output = new stdClass();
        if ($this->getPath()) {
            $output = ['path' => $this->getPath()];
        }

        return $output;
    }
}
