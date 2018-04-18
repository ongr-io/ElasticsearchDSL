<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Unit\SearchEndpoint;

use ONGR\ElasticsearchDSL\SearchEndpoint\InnerHitsEndpoint;

/**
 * Class AggregationsEndpointTest.
 */
class InnerHitsEndpointTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf(
            'ONGR\ElasticsearchDSL\SearchEndpoint\InnerHitsEndpoint',
            new InnerHitsEndpoint()
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter()
    {
        $hitName = 'foo';
        $innerHit = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')->getMock();
        $endpoint = new InnerHitsEndpoint();
        $endpoint->add($innerHit, $hitName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($innerHit, $builders[$hitName]);
    }

    /**
     * Tests normalize method
     */
    public function testNormalization()
    {
        $normalizer = $this
            ->getMockBuilder('Symfony\Component\Serializer\Normalizer\NormalizerInterface')
            ->getMock();
        $innerHit = $this
            ->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')
            ->setMethods(['getName', 'toArray', 'getType'])
            ->getMock();
        $innerHit->expects($this->any())->method('getName')->willReturn('foo');
        $innerHit->expects($this->any())->method('toArray')->willReturn(['foo' => 'bar']);

        $endpoint = new InnerHitsEndpoint();
        $endpoint->add($innerHit, 'foo');
        $expected = [
            'foo' => [
                'foo' => 'bar'
            ]
        ];

        $this->assertEquals(
            $expected,
            $endpoint->normalize($normalizer)
        );
    }
}
