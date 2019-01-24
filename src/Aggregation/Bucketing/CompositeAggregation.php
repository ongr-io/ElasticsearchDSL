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
     * @param BuilderInterface[] $sources
     */
    public function __construct($name, $sources = [])
    {
        parent::__construct($name);

        foreach ($sources as $agg) {
            $this->addSource($agg);
        }
    }

    /**
     * @param BuilderInterface $agg
     *
     * @throws \LogicException
     *
     * @return self
     */
    public function addSource(BuilderInterface $agg)
    {
        $this->sources[] = [
            $agg->getName() => [ $agg->getType() => $agg->getArray() ]
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
