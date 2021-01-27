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
use ONGR\ElasticsearchDSL\ScriptAwareTrait;

/**
 * Class representing StatsAggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-stats-aggregation.html
 */
class StatsAggregation extends AbstractAggregation
{
    use MetricTrait;

    use ScriptAwareTrait;

    public function __construct(
        private string $name,
        private ?string $field = null,
        ?string $script = null
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setScript($script);
    }

    public function getType(): string
    {
        return 'stats';
    }

    public function getArray(): array
    {
        $out = [];

        if ($this->getField()) {
            $out['field'] = $this->getField();
        }

        if ($this->getScript()) {
            $out['script'] = $this->getScript();
        }

        return $out;
    }
}
