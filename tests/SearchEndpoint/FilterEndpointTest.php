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
use ONGR\ElasticsearchDSL\Query\FilteredQuery;
use ONGR\ElasticsearchDSL\SearchEndpoint\FilterEndpoint;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class FilterEndpointTest.
 */
class FilterEndpointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf(
            'ONGR\ElasticsearchDSL\SearchEndpoint\FilterEndpoint',
            new FilterEndpoint()
        );
    }

    /**
     * Tests if correct order is returned.
     */
    public function testGetOrder()
    {
        $instance = new FilterEndpoint();
        $this->assertEquals(1, $instance->getOrder());
    }

    /**
     * Test normalization.
     */
    public function testNormalization()
    {
        $instance = new FilterEndpoint();
        /** @var NormalizerInterface|MockObject $normalizerInterface */
        $normalizerInterface = $this->getMockForAbstractClass(
            'Symfony\Component\Serializer\Normalizer\NormalizerInterface'
        );
        $this->assertNull($instance->normalize($normalizerInterface));
        $this->assertFalse($instance->hasReference('filtered_query'));

        /** @var BuilderInterface|MockObject $builderInterface1 */
        $builderInterface1 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        $builderInterface1->expects($this->exactly(1))->method('toArray')->willReturn(['array' => 'data']);
        $builderInterface1->expects($this->exactly(1))->method('getType')->willReturn('test');
        $instance->addBuilder($builderInterface1);

        $this->assertNull($instance->normalize($normalizerInterface));
        $this->assertTrue($instance->hasReference('filtered_query'));
        /** @var FilteredQuery $reference */
        $reference = $instance->getReference('filtered_query');
        $this->assertInstanceOf('ONGR\ElasticsearchDSL\Query\FilteredQuery', $reference);
        $this->assertSame($builderInterface1, $reference->getFilter());

        $instance = new FilterEndpoint();
        /** @var BuilderInterface|MockObject $builderInterface2 */
        $builderInterface2 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        $builderInterface2->expects($this->exactly(1))->method('toArray')->willReturn(['array2' => 'data2']);
        $builderInterface2->expects($this->exactly(1))->method('getType')->willReturn('test2');
        $instance->addBuilder($builderInterface1);
        $instance->addBuilder($builderInterface2);

        $this->assertNull($instance->normalize($normalizerInterface));
        $this->assertTrue($instance->hasReference('filtered_query'));
        $reference = $instance->getReference('filtered_query');
        $this->assertInstanceOf('ONGR\ElasticsearchDSL\Query\FilteredQuery', $reference);
        $this->assertInstanceOf('ONGR\ElasticsearchDSL\Filter\BoolFilter', $reference->getFilter());
    }
}
