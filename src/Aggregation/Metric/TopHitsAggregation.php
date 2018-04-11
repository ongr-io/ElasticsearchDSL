<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;
use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Top hits aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-top-hits-aggregation.html
 */
class TopHitsAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * @var int Number of top matching hits to return per bucket.
     */
    private $size;

    /**
     * @var int The offset from the first result you want to fetch.
     */
    private $from;

    /**
     * @var BuilderInterface[] How the top matching hits should be sorted.
     */
    private $sorts = [];

    /**
     * Constructor for top hits.
     *
     * @param string                $name Aggregation name.
     * @param null|int              $size Number of top matching hits to return per bucket.
     * @param null|int              $from The offset from the first result you want to fetch.
     * @param null|BuilderInterface $sort How the top matching hits should be sorted.
     */
    public function __construct($name, $size = null, $from = null, $sort = null)
    {
        parent::__construct($name);
        $this->setFrom($from);
        $this->setSize($size);
        $this->addSort($sort);
    }

    /**
     * Return from.
     *
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set from.
     *
     * @param int $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return BuilderInterface[]
     */
    public function getSorts()
    {
        return $this->sorts;
    }

    /**
     * @param BuilderInterface[] $sorts
     */
    public function setSorts(array $sorts)
    {
        $this->sorts = $sorts;
    }

    /**
     * Add sort.
     *
     * @param BuilderInterface $sort
     */
    public function addSort($sort)
    {
        $this->sorts[] = $sort;
    }

    /**
     * Set size.
     *
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Return size.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'top_hits';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $sortsOutput = [];
        $addedSorts = array_filter($this->getSorts());
        if ($addedSorts) {
            foreach ($addedSorts as $sort) {
                $sortsOutput[] = $sort->toArray();
            }
        } else {
            $sortsOutput = null;
        }

        $output = array_filter(
            [
                'sort' => $sortsOutput,
                'size' => $this->getSize(),
                'from' => $this->getFrom(),
            ],
            function ($val) {
                return (($val || is_array($val) || ($val || is_numeric($val))));
            }
        );

        return empty($output) ? new \stdClass() : $output;
    }

    /**
     * @deprecated sorts now is a container, use `getSorts()`instead.
     * Return sort.
     *
     * @return BuilderInterface
     */
    public function getSort()
    {
        if (isset($this->sorts[0])) {
            return $this->sorts[0];
        }

        return null;
    }

    /**
     * @deprecated sorts now is a container, use `addSort()`instead.
     *
     * Set sort.
     *
     * @param BuilderInterface $sort
     */
    public function setSort(BuilderInterface $sort)
    {
        $this->sort = $sort;
    }
}
