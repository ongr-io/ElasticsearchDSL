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
use ONGR\ElasticsearchDSL\SearchEndpoint\BuilderContainerAwareTrait;

/**
 * Class BuilderContainerAwareTraitTest.
 */
class BuilderContainerAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BuilderContainerAwareTrait|\PHPUnit_Framework_MockObject_MockObject
     */
    private $instance;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->instance = $this->getMockForTrait('ONGR\\ElasticsearchDSL\\SearchEndpoint\\BuilderContainerAwareTrait');
    }

    /**
     * Tests builder parameters.
     */
    public function testBuilderParameters()
    {
        $this->assertSame([], $this->instance->getBuilderParameters('non_existing_builder'));
        $this->assertSame(
            $this->instance,
            $this->instance->setBuilderParameters('key', [ 'builder' => 'parameter' ])
        );
        $this->assertSame([ 'builder' => 'parameter' ], $this->instance->getBuilderParameters('key'));
    }

    /**
     * Tests interactions with builders.
     */
    public function testBuilders()
    {
        $this->assertSame([], $this->instance->getBuilders());
        $this->assertNull($this->instance->getBuilder('non_existing_builder'));
        $this->assertSame($this->instance, $this->instance->removeBuilder('non_existing_builder'));

        /** @var BuilderInterface $builder1 */
        $builder1 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        $key1 = $this->instance->addBuilder($builder1, ['parameter' => 'value']);
        $this->assertSame($builder1, $this->instance->getBuilder($key1));
        $this->assertSame(['parameter' => 'value'], $this->instance->getBuilderParameters($key1));
        $builders = $this->instance->getBuilders();
        $this->assertCount(1, $builders);
        $this->assertArrayHasKey($key1, $builders);
        $this->assertSame($builder1, $builders[$key1]);

        /** @var BuilderInterface $builder2 */
        $builder2 = $this->getMockForAbstractClass('ONGR\ElasticsearchDSL\BuilderInterface');
        $key2 = $this->instance->addBuilder($builder2, ['parameter2' => 'value2']);
        $this->assertSame($builder2, $this->instance->getBuilder($key2));
        $this->assertSame(['parameter2' => 'value2'], $this->instance->getBuilderParameters($key2));
        $builders = $this->instance->getBuilders();
        $this->assertCount(2, $builders);
        $this->assertArrayHasKey($key1, $builders);
        $this->assertArrayHasKey($key2, $builders);
        $this->assertSame($builder1, $builders[$key1]);
        $this->assertSame($builder2, $builders[$key2]);

        $this->instance->removeBuilder($key2);
        $this->assertNull($this->instance->getBuilder($key2));
        $this->assertSame([], $this->instance->getBuilderParameters($key2));
        $builders = $this->instance->getBuilders();
        $this->assertCount(1, $builders);
        $this->assertArrayHasKey($key1, $builders);
        $this->assertArrayNotHasKey($key2, $builders);
        $this->assertSame($builder1, $builders[$key1]);
        $this->assertSame($builder1, ($this->instance->getBuilder($key1)));

        $this->instance->removeBuilder($key1);
        $this->assertNull($this->instance->getBuilder($key1));
        $this->assertSame([], $this->instance->getBuilderParameters($key1));
        $this->assertSame([], $this->instance->getBuilders());
    }
}
