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
use ONGR\ElasticsearchDSL\SearchEndpoint\SortEndpoint;
use ONGR\ElasticsearchDSL\Sort\AbstractSort;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class SortEndpointTest.
 */
class SortEndpointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf('ONGR\ElasticsearchDSL\SearchEndpoint\SortEndpoint', new SortEndpoint());
    }

    /**
     * Tests AddBuilder.
     */
    public function testAddBuilder()
    {
        $instance = new SortEndpoint();

        /** @var AbstractSort|MockObject $builderInterface1 */
        $builderInterface1 = $this->getMockBuilder('ONGR\ElasticsearchDSL\Sort\AbstractSort')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $key = $instance->addBuilder($builderInterface1);
        $this->assertNotNull($key);
        $this->assertSame($builderInterface1, $instance->getBuilder($key));

        /** @var BuilderInterface|MockObject $builderInterface2 */
        $builderInterface2 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');

        $this->setExpectedException('InvalidArgumentException', 'Sort must must a subtype of AbstractSort');
        $instance->addBuilder($builderInterface2);
    }

    /**
     * Tests if endpoint return correct normalized data.
     */
    public function testEndpoint()
    {
        $instance = new SortEndpoint();
        /** @var NormalizerInterface|MockObject $normalizerInterface */
        $normalizerInterface = $this->getMockForAbstractClass(
            'Symfony\Component\Serializer\Normalizer\NormalizerInterface'
        );
        $this->assertNull($instance->normalize($normalizerInterface));

        /** @var AbstractSort|MockObject $builderInterface1 */
        $builderInterface1 = $this->getMockBuilder('ONGR\ElasticsearchDSL\Sort\AbstractSort')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $builderInterface1->expects($this->exactly(0))->method('toArray')->willReturn(['array' => 'data']);
        $builderInterface1->expects($this->exactly(2))->method('getType')->willReturn('test');
        $instance->addBuilder($builderInterface1);

        $this->assertSame(['test' => ['order' => 'asc']], $instance->normalize($normalizerInterface));
    }
}
