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

use ONGR\ElasticsearchDSL\Search;

/**
 * Test for Search.
 */
class SearchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Search constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf('ONGR\ElasticsearchDSL\Search', new Search());
    }

    /**
     * Data provider for test testSettingParams()
     *
     * @return array
     */
    public function getTestSettingParamsData()
    {
        $cases = [];

        $search = new Search();
        $search->setSize(3);
        $cases['Only size is set'] = [
            $search,
            [
                'size' => 3,
            ],
        ];

        $search = new Search();
        $search->setFrom(4);
        $cases['Only from is set'] = [
            $search,
            [
                'from' => 4,
            ],
        ];

        $search = new Search();
        $search->setTimeout('2s');
        $cases['Only timeout is set'] = [
            $search,
            [
                'timeout' => '2s',
            ],
        ];

        $search = new Search();
        $search->setTerminateAfter(100);
        $cases['Only terminate_after is set'] = [
            $search,
            [
                'terminate_after' => 100,
            ],
        ];

        $search = new Search();
        $search->setSize(3);
        $search->setFrom(4);
        $search->setTimeout('2s');
        $search->setTerminateAfter(100);
        $cases['Multiple parameters are set'] = [
            $search,
            [
                'size' => 3,
                'from' => 4,
                'timeout' => '2s',
                'terminate_after' => 100,
            ],
        ];

        return $cases;
    }

    /**
     * This test checks if parameters are correctly set into Search object.
     *
     * @dataProvider getTestSettingParamsData()
     *
     * @param Search    $search
     * @param array     $expected
     */
    public function testSettingParams($search, $expected)
    {
        $this->assertEquals(
            $expected,
            $search->toArray()
        );
    }
}
