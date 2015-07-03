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
use ONGR\ElasticsearchDSL\SearchEndpoint\HighlightEndpoint;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class HighlightEndpointTest.
 */
class HighlightEndpointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf('ONGR\ElasticsearchDSL\SearchEndpoint\HighlightEndpoint', new HighlightEndpoint());
    }

    /**
     * Tests adding builder.
     */
    public function testAddBuilder()
    {
        $instance = new HighlightEndpoint();

        /** @var BuilderInterface|MockObject $builderInterface1 */
        $builderInterface1 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        $key = $instance->addBuilder($builderInterface1);
        $this->assertNotNull($key);
        $this->assertSame($builderInterface1, $instance->getBuilder($key));

        $this->setExpectedException('OverflowException', 'Only one highlight is expected');
        $instance->addBuilder($builderInterface1);
    }

    /**
     * Tests adding builder.
     */
    public function testNormalization()
    {
        $instance = new HighlightEndpoint();
        /** @var NormalizerInterface|MockObject $normalizerInterface */
        $normalizerInterface = $this->getMockForAbstractClass(
            'Symfony\Component\Serializer\Normalizer\NormalizerInterface'
        );

        $this->assertNull($instance->normalize($normalizerInterface));

        /** @var BuilderInterface|MockObject $builderInterface1 */
        $builderInterface1 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        $builderInterface1->expects($this->exactly(1))->method('toArray')->willReturn(['array' => 'data']);
        $builderInterface1->expects($this->exactly(0))->method('getType')->willReturn('test');

        $instance->addBuilder($builderInterface1);
        $this->assertSame(['array' => 'data'], $instance->normalize($normalizerInterface));
    }
}
