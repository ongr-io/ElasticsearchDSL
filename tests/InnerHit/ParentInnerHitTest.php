<?php

namespace ONGR\ElasticsearchDSL\Tests\InnerHit;

use ONGR\ElasticsearchDSL\InnerHit\ParentInnerHit;
use ONGR\ElasticsearchDSL\Query\TermQuery;

class ParentInnerHitTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $query = new TermQuery('foo', 'bar');
        $hit = new ParentInnerHit('test', 'acme', $query);
        $expected = [
            'type' => [
                'acme' => [
                    'query' => $query->toArray(),
                ],
            ],
        ];
        $this->assertEquals($expected, $hit->toArray());
    }
}
