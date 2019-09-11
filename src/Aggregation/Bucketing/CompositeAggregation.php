<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;
use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Class representing composite aggregation.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-composite-aggregation.html
 */
class CompositeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var BuilderInterface[]
     */
    private $sources = [];

    /**
     * Inner aggregations container init.
     *
     * @param string             $name
     * @param AbstractAggregation[] $sources
     */
    public function __construct($name, $sources = [])
    {
        parent::__construct($name);

        foreach ($sources as $agg) {
            $this->addSource($agg);
        }
    }

    /**
     * @param AbstractAggregation $agg
     *
     * @throws \LogicException
     *
     * @return self
     */
    public function addSource(AbstractAggregation $agg)
    {
        $array = $agg->getArray();

        $array = is_array($array) ? array_merge($array, $agg->getParameters()) : $array;

        $this->sources[] = [
            $agg->getName() => [ $agg->getType() => $array ]
        ];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        return [
            'sources' => $this->sources,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'composite';
    }
}
