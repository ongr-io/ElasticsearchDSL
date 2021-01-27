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
 * Class representing AutoDateHistogramAggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-autodatehistogram-aggregation.html
 */
class AutoDateHistogramAggregation extends AbstractAggregation
{
    use BucketingTrait;

    public function __construct(
        private string $name,
        private string $field,
        private ?int $buckets = null,
        private ?string $format = null
    ) {
        parent::__construct($name);

        $this->setField($field);

        if ($buckets) {
            $this->addParameter('buckets', $buckets);
        }

        if ($format) {
            $this->addParameter('format', $format);
        }
    }

    public function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
            ]
        );
    }

    public function getType(): string
    {
        return 'auto_date_histogram';
    }
}
