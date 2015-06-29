<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Query\Span;

use ONGR\ElasticsearchDSL\Query\Span\SpanTermQuery;

/**
 * Unit test for SpanTermQuery.
 */
class SpanTermQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests get Type method.
     */
    public function testSpanTermQueryGetType()
    {
        $query = new SpanTermQuery('field', 'value');
        $result = $query->getType();
        $this->assertEquals('span_term', $result);
    }
}
