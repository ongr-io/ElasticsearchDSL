<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Tests\Unit\DSL\Suggester\Context;

use ONGR\ElasticsearchBundle\DSL\Suggester\Context\CategoryContext;
use ONGR\ElasticsearchBundle\Test\EncapsulationTestAwareTrait;

class CategoryContextTest extends \PHPUnit_Framework_TestCase
{
    use EncapsulationTestAwareTrait;

    /**
     * @return string
     */
    public function getClassName()
    {
        $this->setStub(new CategoryContext('foo', 'bar'));

        return 'ONGR\ElasticsearchBundle\DSL\Suggester\Context\CategoryContext';
    }

    /**
     * @return array
     */
    public function getFieldsData()
    {
        return [
            ['name'],
            ['value'],
        ];
    }
}
