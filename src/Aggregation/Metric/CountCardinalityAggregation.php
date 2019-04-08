<?php
declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;

/**
 * Class CountCardinalityAggregation
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-cardinality-aggregation.html
 *
 * @package ONGR\ElasticsearchDSL\Aggregation\Metric
 */
class CountCardinalityAggregation extends AbstractAggregation
{
    /**
     * CountAggregation constructor.
     * @param $name
     * @param null $field
     */
    public function __construct($name, $field = null)
    {
        parent::__construct($name);

        $this->setField($field);
    }

    /**
     * @return array|\stdClass
     */
    protected function getArray()
    {
        $data = array_filter(
            [
                'field' => $this->getField(),
            ]
        );

        return $data;
    }

    /**
     * @return bool
     */
    protected function supportsNesting()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'cardinality';
    }
}
