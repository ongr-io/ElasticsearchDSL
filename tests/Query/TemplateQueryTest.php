<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Query;

use ONGR\ElasticsearchDSL\Query\TemplateQuery;

/**
 * Unit test for Template.
 */
class TemplateQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests toArray() method.
     */
    public function testTemplateToArray()
    {
        $inline = '\"term\": {\"field\": \"{{query_string}}\"}';
        $params = ['query_string' => 'all about search'];
        $and = new TemplateQuery($inline, $params);
        $expected = [
            'template' => [
                'inline' => '\"term\": {\"field\": \"{{query_string}}\"}',
                'params' => $params
            ],
        ];
        $this->assertEquals($expected, $and->toArray());
    }
}
