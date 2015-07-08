<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Query;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Query\FunctionScoreQuery;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Tests for FunctionScoreQuery.
 */
class FunctionScoreQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests default argument values.
     */
    public function testAddFieldValueFactorFunction()
    {
        /** @var BuilderInterface|MockObject $builderInterface */
        $builderInterface = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        $functionScoreQuery = new FunctionScoreQuery($builderInterface);
        $functionScoreQuery->addFieldValueFactorFunction('field1', 2);
        $functionScoreQuery->addFieldValueFactorFunction('field2', 1.5, 'ln');

        $this->assertSame(
            [
                'query' => [null => null],
                'functions' => [
                    [
                        'field_value_factor' => [
                            'field' => 'field1',
                            'factor' => 2,
                            'modifier' => 'none',
                        ],
                    ],
                    [
                        'field_value_factor' => [
                            'field' => 'field2',
                            'factor' => 1.5,
                            'modifier' => 'ln',
                        ],
                    ],
                ],
            ],
            $functionScoreQuery->toArray()
        );
    }
}
