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

/**
 * Class representing missing aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-missing-aggregation.html
 */
class MissingAggregation extends AbstractAggregation
{
    use BucketingTrait;

    public function __construct(private string $name, private ?string $field = null)
    {
        parent::__construct($name);
    }

    public function getArray(): array
    {
        if ($this->getField()) {
            return ['field' => $this->getField()];
        }

        throw new \LogicException('Missing aggregation must have a field set.');
    }

    public function getType(): string
    {
        return 'missing';
    }
}
