<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL;

use ONGR\ElasticsearchDSL\Aggregation\GlobalAggregation;
use ONGR\ElasticsearchDSL\Filter\MatchAllFilter;
use ONGR\ElasticsearchDSL\FilterOrQueryDetectionTrait;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;

/**
 * Test for FilterOrQueryDetectionTrait.
 */
class FilterOrQueryDetectionTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FilterOrQueryDetectionTrait
     */
    private $mock;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->mock = $this->getMockForTrait('ONGR\ElasticsearchDSL\FilterOrQueryDetectionTrait');
    }

    /**
     * Tests if setDslType throws exception.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testIfTraitDetectsNotKnowType()
    {
        $aggregation = new GlobalAggregation('global');
        $this->mock->detectDslType($aggregation);
    }

    /**
     * Tests if detectDslType detects passed query.
     */
    public function testIfTraitDetectsQuery()
    {
        $query = new MatchAllQuery();
        $result = $this->mock->detectDslType($query);

        $this->assertEquals('query', $result);
    }

    /**
     * Tests if detectDslType detects passed filter.
     */
    public function testIfTraitDetectsFilter()
    {
        $filter = new MatchAllFilter();
        $result = $this->mock->detectDslType($filter);

        $this->assertEquals('filter', $result);
    }
}
