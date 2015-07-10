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
use ONGR\ElasticsearchDSL\SearchEndpoint\PostFilterEndpoint;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class PostFilterEndpointTest.
 */
class PostFilterEndpointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf('ONGR\ElasticsearchDSL\SearchEndpoint\PostFilterEndpoint', new PostFilterEndpoint());
    }

    /**
     * Test normalization.
     */
    public function testNormalization()
    {
        $instance = new PostFilterEndpoint();
        /** @var NormalizerInterface|MockObject $normalizerInterface */
        $normalizerInterface = $this->getMockForAbstractClass(
            'Symfony\Component\Serializer\Normalizer\NormalizerInterface'
        );
        $this->assertNull($instance->normalize($normalizerInterface));

        /** @var BuilderInterface|MockObject $builderInterface1 */
        $builderInterface1 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        $builderInterface1->expects($this->exactly(1))->method('toArray')->willReturn(['array' => 'data']);
        $builderInterface1->expects($this->exactly(1))->method('getType')->willReturn('test');

        $instance->addBuilder($builderInterface1);
        $this->assertSame(['test' => ['array' => 'data']], $instance->normalize($normalizerInterface));
    }
}
