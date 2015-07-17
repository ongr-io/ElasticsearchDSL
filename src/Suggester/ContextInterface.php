<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Suggester;

/**
 * Interface ContextInterface.
 */
interface ContextInterface
{
    /**
     * Converts context to an array.
     *
     * @return array
     */
    public function toArray();

    /**
     * Returns context name.
     *
     * @return mixed
     */
    public function getName();
}
