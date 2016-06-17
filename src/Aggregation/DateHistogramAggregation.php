<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;

/**
 * Class representing Histogram aggregation.
 */
class DateHistogramAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var string
     */
    protected $interval;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param string    $interval
     * @param array  $parameters
     */
    public function __construct(
        $name,
        $field = null,
        $interval = null,
        $parameters = []
    ) {
        parent::__construct($name);

        $this->setField($field);
        $this->setInterval($interval);
        $this->setParameters($parameters);
    }

    /**
     * @return int
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param string $interval
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'date_histogram';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $out = [
            'field' => $this->getField(),
            'interval' => $this->getInterval(),
        ];
        $out = $this->processArray($out);
        $this->checkRequiredParameters($out);

        return $out;
    }

    /**
     * Checks if all required parameters are set.
     *
     * @param array $data
     *
     * @throws \LogicException
     */
    protected function checkRequiredParameters(array $data)
    {
        if (!$data['field'] || !$data['interval']) {
            throw new \LogicException('Date histogram aggregation must have field and interval set.');
        }
    }
}
