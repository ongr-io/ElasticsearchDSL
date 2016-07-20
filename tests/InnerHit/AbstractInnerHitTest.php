<?php

namespace ONGR\ElasticsearchDSL\Tests\InnerHit;

use ONGR\ElasticsearchDSL\InnerHit\AbstractInnerHit;
use ONGR\ElasticsearchDSL\Query\MatchQuery;
use ONGR\ElasticsearchDSL\Query\TermQuery;

class AbstractInnerHitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests getters and setters for $name, $path and $query
     */
    public function testGettersAndSetters()
    {
        $stub = $this->getAbstractInnerHitMock();
        $query = new TermQuery('acme', 'test');
        $stub->setName('foo');
        $stub->setPath('bar');
        $stub->setQuery($query);

        $this->assertEquals('foo', $stub->getName());
        $this->assertEquals('bar', $stub->getPath());
        $this->assertEquals($query, $stub->getQuery());
    }

    /**
     * Tests adding and retrieving nested inner hits
     */
    public function testAddingInnerHits()
    {
        $stub = $this->getAbstractInnerHitMock();
        $nestedInnerHit1 = $this->getAbstractInnerHitMock();
        $nestedInnerHit2 = $this->getAbstractInnerHitMock();
        $nestedInnerHit2->setName('foo');
        $stub->addInnerHit($nestedInnerHit1);
        $stub->addInnerHit($nestedInnerHit2);
        $this->assertEquals(
            $nestedInnerHit1,
            $stub->getInnerHit(
                $nestedInnerHit1->getName()
            )
        );
        $this->assertEquals(
            [
                $nestedInnerHit1->getName() => $nestedInnerHit1,
                $nestedInnerHit2->getName() => $nestedInnerHit2,
            ],
            $stub->getInnerHits()
        );
    }

    /**
     * Tests collectNestedInnerHits method
     */
    public function testCollectNestedInnerHits()
    {
        $query = new MatchQuery('foo', 'bar');
        $stub = $this->getAbstractInnerHitMock();
        $nestedInnerHit1 = $this->getAbstractInnerHitMock();
        $nestedInnerHit2 = $this->getAbstractInnerHitMock();
        $nestedInnerHit2->setName('foo');

        $stub->addInnerHit($nestedInnerHit1);
        $stub->addInnerHit($nestedInnerHit2);

        $expected = [
            'test' => [
                'path' => [
                    'acme' => [
                        'query' => $query->toArray(),
                    ],
                ],
            ],
            'foo' => [
                'path' => [
                    'acme' => [
                        'query' => $query->toArray(),
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $stub->collectNestedInnerHits());
    }

    /**
     * Creates a mock of the abstract inner hit class
     *
     * @return AbstractInnerHit
     */
    private function getAbstractInnerHitMock()
    {
        $query = new MatchQuery('foo', 'bar');
        $stub = $this
            ->getMockForAbstractClass(
                'ONGR\ElasticsearchDSL\InnerHit\AbstractInnerHit',
                ['test', 'acme', $query]
            );
        $toArrayValue = [
            'path' => [
                'acme' => [
                    'query' => $query->toArray(),
                ],
            ],
        ];
        $stub->expects($this->any())
            ->method('toArray')
            ->will($this->returnValue($toArrayValue));

        return $stub;
    }
}
