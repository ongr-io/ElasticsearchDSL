<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\Bucketing\CompositeAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Bucketing\TermsAggregation;

class CompositeAggregationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test for composite aggregation toArray() method exception.
     */
    public function testToArray()
    {
        $compositeAgg = new CompositeAggregation('composite_test_agg');
        $termsAgg = new TermsAggregation('test_term_agg', 'test_field');
        $compositeAgg->addSource($termsAgg);

        $expectedResult = [
            'composite' => [
                'sources' =>  [
                    [
                        'test_term_agg' => [ 'terms' => ['field' => 'test_field'] ],
                    ]
                ]
            ],
        ];

        $this->assertEquals($expectedResult, $compositeAgg->toArray());
    }

    /**
     * Test for composite aggregation toArray() method with size and after part.
     */
    public function testToArrayWithSizeAndAfter()
    {
        $compositeAgg = new CompositeAggregation('composite_test_agg');
        $termsAgg = new TermsAggregation('test_term_agg', 'test_field');
        $compositeAgg->addSource($termsAgg);
        $compositeAgg->setSize(5);
        $compositeAgg->setAfter(['test_term_agg' => 'test']);

        $expectedResult = [
            'composite' => [
                'sources' =>  [
                    [
                        'test_term_agg' => [ 'terms' => ['field' => 'test_field'] ],
                    ]
                ],
                'size' => 5,
                'after' => ['test_term_agg' => 'test']
            ],
        ];

        $this->assertEquals($expectedResult, $compositeAgg->toArray());
    }

    /**
     * Test for composite aggregation getSize() method.
     */
    public function testGetSize()
    {
        $compositeAgg = new CompositeAggregation('composite_test_agg');
        $compositeAgg->setSize(5);

        $this->assertEquals(5, $compositeAgg->getSize());
    }

    /**
     * Test for composite aggregation getAfter() method.
     */
    public function testGetAfter()
    {
        $compositeAgg = new CompositeAggregation('composite_test_agg');
        $compositeAgg->setAfter(['test_term_agg' => 'test']);

        $this->assertEquals(['test_term_agg' => 'test'], $compositeAgg->getAfter());
    }

    /**
     * Tests getType method.
     */
    public function testGetType()
    {
        $aggregation = new CompositeAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('composite', $result);
    }

    public function testTermsSourceWithOrderParameter()
    {
        $compositeAgg = new CompositeAggregation('composite_with_order');
        $termsAgg = new TermsAggregation('test_term_agg', 'test_field');
        $termsAgg->addParameter('order', 'asc');
        $compositeAgg->addSource($termsAgg);

        $expectedResult = [
            'composite' => [
                'sources' =>  [
                    [
                        'test_term_agg' => [ 'terms' => ['field' => 'test_field', 'order' => 'asc'] ],
                    ]
                ]
            ],
        ];

        $this->assertEquals($expectedResult, $compositeAgg->toArray());
    }


    public function testTermsSourceWithDescOrderParameter()
    {
        $compositeAgg = new CompositeAggregation('composite_with_order');
        $termsAgg = new TermsAggregation('test_term_agg', 'test_field');
        $termsAgg->addParameter('order', 'desc');
        $compositeAgg->addSource($termsAgg);

        $expectedResult = [
            'composite' => [
                'sources' =>  [
                    [
                        'test_term_agg' => [ 'terms' => ['field' => 'test_field', 'order' => 'desc'] ],
                    ]
                ]
            ],
        ];

        $this->assertEquals($expectedResult, $compositeAgg->toArray());
    }


    public function testMultipleSourcesWithDifferentOrders()
    {
        $compositeAgg = new CompositeAggregation('composite_with_order');

        $termsAgg = new TermsAggregation('test_term_agg_1', 'test_field');
        $termsAgg->addParameter('order', 'desc');
        $compositeAgg->addSource($termsAgg);

        $termsAgg = new TermsAggregation('test_term_agg_2', 'test_field');
        $termsAgg->addParameter('order', 'asc');
        $compositeAgg->addSource($termsAgg);

        $expectedResult = [
            'composite' => [
                'sources' =>  [
                    [
                        'test_term_agg_1' => [ 'terms' => ['field' => 'test_field', 'order' => 'desc'] ],
                    ],
                    [
                        'test_term_agg_2' => [ 'terms' => ['field' => 'test_field', 'order' => 'asc'] ],
                    ]
                ]
            ],
        ];

        $this->assertEquals($expectedResult, $compositeAgg->toArray());
    }
}
