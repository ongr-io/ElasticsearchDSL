<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Suggester;

use ONGR\ElasticsearchBundle\DSL\Suggester\Completion;
use ONGR\ElasticsearchBundle\DSL\Suggester\Context;
use ONGR\ElasticsearchBundle\DSL\Suggester\Phrase;

class ContextTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests toArray method when $this->getSize() !== null.
     */
    public function testToArrayNotNull()
    {
        $name = 'testName';

        $context = new Context('', '', $name);
        $context->setSize(123);
        $context->setContext(new Phrase('', ''));

        $result = $context->toArray();

        $this->assertArrayHasKey($name, $result);

        $data = $result[$name];
        $this->assertArrayHasKey('completion', $data);

        $completion = $data['completion'];
        $this->assertArrayHasKey('size', $completion);

        $this->assertEquals($completion['size'], 123);
    }
}
