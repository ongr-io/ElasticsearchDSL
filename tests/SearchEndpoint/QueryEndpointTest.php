<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\SearchEndpoint;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\Query\BoolQuery;
use ONGR\ElasticsearchDSL\SearchEndpoint\QueryEndpoint;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Unit test class for the QueryEndpoint.
 */
class QueryEndpointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf('ONGR\ElasticsearchDSL\SearchEndpoint\QueryEndpoint', new QueryEndpoint());
    }

    /**
     * Tests if correct order is returned.
     */
    public function testGetOrder()
    {
        $instance = new QueryEndpoint();
        $this->assertEquals(2, $instance->getOrder());
    }

    /**
     * Tests if endpoint return correct normalized data.
     */
    public function testEndpoint()
    {
        $instance = new QueryEndpoint();
        /** @var NormalizerInterface|MockObject $normalizerInterface */
        $normalizerInterface = $this->getMockForAbstractClass(
            'Symfony\Component\Serializer\Normalizer\NormalizerInterface'
        );

        $this->assertNull($instance->normalize($normalizerInterface));
        /** @var BuilderInterface|MockObject $builderInterface1 */
        $builderInterface1 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        $builderInterface1->expects($this->exactly(3))->method('toArray')->willReturn(['array' => 'data']);
        $builderInterface1->expects($this->exactly(3))->method('getType')->willReturn('test');

        $instance->addBuilder($builderInterface1);
        $data = $instance->normalize($normalizerInterface);
        $this->assertEquals(['test' => ['array' => 'data']], $data);

        /** @var BuilderInterface|MockObject $builderInterface2 */
        $builderInterface2 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        $builderInterface2->expects($this->exactly(2))->method('toArray')->willReturn(['array2' => 'data2']);
        $builderInterface2->expects($this->exactly(2))->method('getType')->willReturn('test2');

        $instance->addBuilder($builderInterface2);
        $data = $instance->normalize($normalizerInterface);
        $this->assertEquals(
            [
                'bool' => [
                    'must' => [
                        [ 'test' => [ 'array' => 'data' ] ],
                        [ 'test2' => [ 'array2' => 'data2' ] ],
                    ],
                ],
            ],
            $data
        );

        /** @var BuilderInterface|MockObject $builderInterface3 */
        $builderInterface3 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        $builderInterface3->expects($this->once())->method('toArray')->willReturn(['array3' => 'data3']);
        $builderInterface3->expects($this->once())->method('getType')->willReturn('test3');
        $instance->addBuilder($builderInterface3, ['bool_type' => BoolQuery::SHOULD]);
        $instance->setParameters(['some' => 'parameter']);
        $data = $instance->normalize($normalizerInterface);
        $this->assertEquals(
            [
                'bool' => [
                    'must' => [
                        [ 'test' => [ 'array' => 'data' ] ],
                        [ 'test2' => [ 'array2' => 'data2' ] ],
                    ],
                    'should' => [
                        [ 'test3' => [ 'array3' => 'data3' ] ],
                    ],
                    'some' => 'parameter',
                ],
            ],
            $data
        );
    }
}
