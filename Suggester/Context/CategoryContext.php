<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Suggester\Context;

/**
 * Category context to be used by context suggester.
 */
class CategoryContext extends AbstractContext
{
    /**
     * {@inheritdoc}
     *
     * @return array|string
     */
    public function toArray()
    {
        return $this->getValue();
    }
}
