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

use ONGR\ElasticsearchDSL\SearchEndpoint\SuggestEndpoint;
use ONGR\ElasticsearchDSL\Suggest\Suggest;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SuggestEndpointTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests constructor.
     */
    public function testItCanBeInstantiated()
    {
        $this->assertInstanceOf('ONGR\ElasticsearchDSL\SearchEndpoint\SuggestEndpoint', new SuggestEndpoint());
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter()
    {
        $suggestName = 'acme_suggest';
        $text = 'foo';
        $suggest = new Suggest($suggestName, 'text', $text, 'acme');
        $endpoint = new SuggestEndpoint();
        $endpoint->add($suggest, $suggestName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($suggest, $builders[$suggestName]);
    }

    /**
     * Tests endpoint normalization.
     */
    public function testNormalize()
    {
        $instance = new SuggestEndpoint();

        /** @var NormalizerInterface|MockObject $normalizerInterface */
        $normalizerInterface = $this->getMockForAbstractClass(
            'Symfony\Component\Serializer\Normalizer\NormalizerInterface'
        );

        $suggest = new Suggest('foo', 'bar', 'acme', 'foo');
        $instance->add($suggest);

        $this->assertEquals(
            $suggest->toArray(),
            $instance->normalize($normalizerInterface)
        );
    }
}
