<?php

namespace ONGR\ElasticsearchDSL\Tests\InnerHit;

use ONGR\ElasticsearchDSL\InnerHit\NestedInnerHit;
use ONGR\ElasticsearchDSL\Query\MatchQuery;
use ONGR\ElasticsearchDSL\Query\NestedQuery;
use ONGR\ElasticsearchDSL\Query\TermQuery;

class NestedInnerHitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for testToArray().
     *
     * @return array
     */
    public function getTestToArrayData()
    {
        $out = [];

        $matchQuery = new MatchQuery('foo.bar.aux', 'foo');
        $nestedQuery = new NestedQuery('foo.bar', $matchQuery);
        $innerHit = new NestedInnerHit('acme', 'foo', $nestedQuery);
        $nestedInnerHit1 = new NestedInnerHit('aux', 'foo.bar.aux', $matchQuery);
        $nestedInnerHit2 = new NestedInnerHit('lux', 'foo.bar.aux', $matchQuery);
        $innerHit->addInnerHit($nestedInnerHit1);
        $innerHit->addInnerHit($nestedInnerHit2);

        $out[] = [
            $nestedInnerHit1,
            [
                'path' => [
                    'foo.bar.aux' => [
                        'query' => $matchQuery->toArray(),
                    ],
                ],
            ],
        ];

        $out[] = [
            $innerHit,
            [
                'path' => [
                    'foo' => [
                        'query' => $nestedQuery->toArray(),
                        'inner_hits' => [
                            'aux' => [
                                'path' => [
                                    'foo.bar.aux' => [
                                        'query' => $matchQuery->toArray(),
                                    ],
                                ],
                            ],
                            'lux' => [
                                'path' => [
                                    'foo.bar.aux' => [
                                        'query' => $matchQuery->toArray(),
                                    ],
                                ],
                            ]
                        ],
                    ],
                ],
            ],
        ];

        return $out;
    }


    /**
     * Tests toArray() method.
     *
     * @param NestedInnerHit $innerHit
     * @param array          $expected
     *
     * @dataProvider getTestToArrayData
     */
    public function testToArray($innerHit, $expected)
    {
        $this->assertEquals($expected, $innerHit->toArray());
    }


    /**
     * Tests getters and setters for $name, $path and $query
     */
    public function testGettersAndSetters()
    {
        $query = new MatchQuery('acme', 'test');
        $hit = new NestedInnerHit('test', 'acme', new TermQuery('foo', 'bar'));
        $hit->setName('foo');
        $hit->setPath('bar');
        $hit->setQuery($query);

        $this->assertEquals('foo', $hit->getName());
        $this->assertEquals('bar', $hit->getPath());
        $this->assertEquals($query, $hit->getQuery());
    }

    /**
     * Tests getInnerHit() method
     */
    public function testGetInnerHit()
    {
        $query = new MatchQuery('acme', 'test');
        $hit = new NestedInnerHit('test', 'acme', $query);
        $nestedInnerHit1 = new NestedInnerHit('foo', 'acme.foo', $query);
        $nestedInnerHit2 = new NestedInnerHit('bar', 'acme.bar', $query);
        $hit->addInnerHit($nestedInnerHit1);
        $hit->addInnerHit($nestedInnerHit2);

        $this->assertEquals($nestedInnerHit1, $hit->getInnerHit('foo'));
        $this->assertEquals($nestedInnerHit2, $hit->getInnerHit('bar'));
        $this->assertNull($hit->getInnerHit('non_existing_hit'));
    }
}
