<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query;

use ONGR\ElasticsearchDSL\Query\TemplateQuery;

/**
 * Unit test for Template.
 */
class TemplateQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests toArray() method with inline.
     */
    public function testToArrayInline()
    {
        $inline = '"term": {"field": "{{query_string}}"}';
        $params = ['query_string' => 'all about search'];
        $query = new TemplateQuery(null, $inline, $params);
        $expected = [
            'template' => [
                'inline' => $inline,
                'params' => $params
            ],
        ];
        $this->assertEquals($expected, $query->toArray());
    }

    /**
     * Tests toArray() method with file
     */
    public function testToArrayFile()
    {
        $file = 'my_template';
        $params = ['query_string' => 'all about search'];
        $query = new TemplateQuery();
        $query->setFile($file);
        $query->setParams($params);
        $expected = [
            'template' => [
                'file' => $file,
                'params' => $params,
            ],
        ];
        $this->assertEquals($expected, $query->toArray());
    }

    /**
     * Tests toArray() exception
     *
     * @expectedException \InvalidArgumentException
     */
    public function testToArrayException()
    {
        $query = new TemplateQuery();
        $query->toArray();
    }
}
