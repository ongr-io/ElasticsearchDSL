<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Filter;

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;

/**
 * Filters container.
 */
class PostFilter extends AbstractFilter implements BuilderInterface
{
    /**
     * Checks if bool filter is relevant.
     *
     * @return bool
     */
    public function isRelevant()
    {
        return $this->filters->isRelevant();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'post_filter';
    }
}
