<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Aggregation;

use ONGR\ElasticsearchBundle\DSL\Aggregation\TermsAggregation;

class TermsAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for testToArray().
     *
     * @return array
     */
    public function getToArrayData()
    {
        $out = [];

        // Case #0 terms aggregation.
        $aggregation = new TermsAggregation('test_agg');
        $aggregation->setField('test_field');

        $result = [
            'agg_test_agg' => [
                'terms' => [
                    'field' => 'test_field',
                ],
            ],
        ];

        $out[] = [$aggregation, $result];

        // Case #1 terms aggregation with size.
        $aggregation = new TermsAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->setSize(1);

        $result = [
            'agg_test_agg' => [
                'terms' => [
                    'field' => 'test_field',
                    'size' => 1,
                ],
            ],
        ];

        $out[] = [$aggregation, $result];

        // Case #2 terms aggregation with size and min document count.
        $aggregation = new TermsAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->setSize(1);
        $aggregation->setMinDocumentCount(10);

        $result = [
            'agg_test_agg' => [
                'terms' => [
                    'field' => 'test_field',
                    'size' => 1,
                    'min_doc_count' => 10,
                ],
            ],
        ];

        $out[] = [$aggregation, $result];

        // Case #3 terms aggregation with simple include, exclude.
        $aggregation = new TermsAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->setInclude('test_.*');
        $aggregation->setExclude('pizza_.*');

        $result = [
            'agg_test_agg' => [
                'terms' => [
                    'field' => 'test_field',
                    'include' => 'test_.*',
                    'exclude' => 'pizza_.*',
                ],
            ],
        ];

        $out[] = [$aggregation, $result];

        // Case #4 terms aggregation with include, exclude and flags.
        $aggregation = new TermsAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->setInclude('test_.*', 'CANON_EQ|CASE_INSENSITIVE');
        $aggregation->setExclude('pizza_.*', 'CASE_INSENSITIVE');

        $result = [
            'agg_test_agg' => [
                'terms' => [
                    'field' => 'test_field',
                    'include' => [
                        'pattern' => 'test_.*',
                        'flags' => 'CANON_EQ|CASE_INSENSITIVE',
                    ],
                    'exclude' => [
                        'pattern' => 'pizza_.*',
                        'flags' => 'CASE_INSENSITIVE',
                    ],
                ],
            ],
        ];

        $out[] = [$aggregation, $result];

        // Case #5 terms aggregation with order default direction.
        $aggregation = new TermsAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->setOrder(TermsAggregation::MODE_COUNT);

        $result = [
            'agg_test_agg' => [
                'terms' => [
                    'field' => 'test_field',
                    'order' => [
                        '_count' => 'asc',
                    ],
                ],
            ],
        ];

        $out[] = [$aggregation, $result];

        // Case #6 terms aggregation with order term mode, desc direction.
        $aggregation = new TermsAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->setOrder(TermsAggregation::MODE_TERM, TermsAggregation::DIRECTION_DESC);

        $result = [
            'agg_test_agg' => [
                'terms' => [
                    'field' => 'test_field',
                    'order' => [
                        '_term' => 'desc',
                    ],
                ],
            ],
        ];

        $out[] = [$aggregation, $result];

        return $out;
    }

    /**
     * Test for toArray().
     *
     * @param TermsAggregation $aggregation
     * @param array            $expectedResults
     *
     * @dataProvider getToArrayData
     */
    public function testToArray($aggregation, $expectedResults)
    {
        $this->assertEquals($expectedResults, $aggregation->toArray());
    }
}
