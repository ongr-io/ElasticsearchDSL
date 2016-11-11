<?php

namespace ONGR\ElasticsearchDSL\Tests\Unit\InnerHit;

use ONGR\ElasticsearchDSL\InnerHit\NestedInnerHit;
use ONGR\ElasticsearchDSL\Query\MatchQuery;
use ONGR\ElasticsearchDSL\Query\NestedQuery;
use ONGR\ElasticsearchDSL\Search;

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
        $searchQuery = new Search();
        $searchQuery->addQuery($nestedQuery);

        $matchSearch = new Search();
        $matchSearch->addQuery($matchQuery);

        $innerHit = new NestedInnerHit('acme', 'foo', $searchQuery);
        $emptyInnerHit = new NestedInnerHit('acme', 'foo');

        $nestedInnerHit1 = new NestedInnerHit('aux', 'foo.bar.aux', $matchSearch);
        $nestedInnerHit2 = new NestedInnerHit('lux', 'foo.bar.aux', $matchSearch);
        $searchQuery->addInnerHit($nestedInnerHit1);
        $searchQuery->addInnerHit($nestedInnerHit2);

        $out[] = [
            $emptyInnerHit,
            [
                'path' => [
                    'foo' => new \stdClass(),
                ],
            ],
        ];

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
        $search = new Search();
        $search->addQuery($query);

        $hit = new NestedInnerHit('test', 'acme', new Search());
        $hit->setName('foo');
        $hit->setPath('bar');
        $hit->setSearch($search);

        $this->assertEquals('foo', $hit->getName());
        $this->assertEquals('bar', $hit->getPath());
        $this->assertEquals($search, $hit->getSearch());
    }
}
