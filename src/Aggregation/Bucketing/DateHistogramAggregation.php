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
 * Class representing Histogram aggregation.
 *
 * @link https://goo.gl/hGCdDd
 */
class DateHistogramAggregation extends AbstractAggregation
{
    use BucketingTrait;

    public function __construct(
        private string $name,
        private ?string $field = null,
        private mixed $interval = null,
        private $format = null
    ) {
        parent::__construct($name);
    }

    public function getInterval(): mixed
    {
        return $this->interval;
    }

    public function setInterval(mixed $interval): static
    {
        $this->interval = $interval;

        return $this;
    }

    public function setFormat(?string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function getType(): string
    {
        return 'date_histogram';
    }

    public function getArray(): array
    {
        if (!$this->getField() || !$this->getInterval()) {
            throw new \LogicException('Date histogram aggregation must have field and interval set.');
        }

        $out = [
            'field' => $this->getField(),
            'interval' => $this->getInterval(),
        ];

        if (!empty($this->format)) {
            $out['format'] = $this->format;
        }

        return $out;
    }
}
