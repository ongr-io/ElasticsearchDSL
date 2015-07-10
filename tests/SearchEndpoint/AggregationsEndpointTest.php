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
use ONGR\ElasticsearchDSL\NamedBuilderInterface;
use ONGR\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class AggregationsEndpointTest.
 */
class AggregationsEndpointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf(
            'ONGR\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint',
            new AggregationsEndpoint()
        );
    }

    /**
     * Tests AddBuilder.
     */
    public function testAddBuilder()
    {
        $instance = new AggregationsEndpoint();

        /** @var NamedBuilderInterface|MockObject $builderInterface1 */
        $builderInterface1 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\NamedBuilderInterface');
        $builderInterface1->expects($this->any())->method('getName')->willReturn('namedBuilder');
        $key = $instance->addBuilder($builderInterface1);
        $this->assertSame('namedBuilder', $key);
        $this->assertSame($builderInterface1, $instance->getBuilder($key));

        /** @var BuilderInterface|MockObject $builderInterface2 */
        $builderInterface2 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');

        $this->setExpectedException('InvalidArgumentException', 'Builder must be named builder');
        $instance->addBuilder($builderInterface2);
    }

    /**
     * Tests removing builders.
     */
    public function testRemoveBuilder()
    {
        $instance = new AggregationsEndpoint();
        /** @var NamedBuilderInterface|MockObject $builderInterface1 */
        $builderInterface1 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\NamedBuilderInterface');
        $builderInterface1->expects($this->any())->method('getName')->willReturn('namedBuilder');
        $key = $instance->addBuilder($builderInterface1);

        $this->assertNotNull($instance->getBuilder($key));
        $this->assertSame($instance, $instance->removeBuilder($key));
        $this->assertNull($instance->getBuilder($key));
    }

    /**
     * Tests getting all builders.
     */
    public function testGetBuilders()
    {
        $instance = new AggregationsEndpoint();
        $this->assertSame([], $instance->getBuilders());

        /** @var NamedBuilderInterface|MockObject $builderInterface1 */
        $builderInterface1 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\NamedBuilderInterface');
        $builderInterface1->expects($this->any())->method('getName')->willReturn('namedBuilder');

        $instance->addBuilder($builderInterface1);
        $this->assertSame(['namedBuilder' => $builderInterface1], $instance->getBuilders());

        /** @var NamedBuilderInterface|MockObject $builderInterface2 */
        $builderInterface2 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\NamedBuilderInterface');
        $builderInterface2->expects($this->any())->method('getName')->willReturn('namedBuilder2');

        $instance->addBuilder($builderInterface2);
        $this->assertSame(
            [
                'namedBuilder' => $builderInterface1,
                'namedBuilder2' => $builderInterface2,
            ],
            $instance->getBuilders()
        );
    }

    /**
     * Tests normalization builder.
     */
    public function testNormalization()
    {
        $instance = new AggregationsEndpoint();
        /** @var NormalizerInterface|MockObject $normalizerInterface */
        $normalizerInterface = $this->getMockForAbstractClass(
            'Symfony\Component\Serializer\Normalizer\NormalizerInterface'
        );

        $this->assertNull($instance->normalize($normalizerInterface));

        /** @var NamedBuilderInterface|MockObject $builderInterface1 */
        $builderInterface1 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\NamedBuilderInterface');
        $builderInterface1->expects($this->any())->method('getName')->willReturn('namedBuilder');
        $builderInterface1->expects($this->exactly(1))->method('toArray')->willReturn(['array' => 'data']);
        $builderInterface1->expects($this->exactly(0))->method('getType')->willReturn('test');

        $instance->addBuilder($builderInterface1);

        $this->assertSame(['array' => 'data'], $instance->normalize($normalizerInterface));
    }
}
