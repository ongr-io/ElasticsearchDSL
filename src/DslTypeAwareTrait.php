<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL;

/**
 * A trait which handles dsl type.
 */
trait DslTypeAwareTrait
{
    /**
     * @var string
     */
    private $dslType;

    /**
     * Returns a dsl type.
     *
     * @return string
     */
    public function getDslType()
    {
        return $this->dslType;
    }

    /**
     * Sets a dsl type.
     *
     * @param string $dslType
     *
     * @throws \InvalidArgumentException
     */
    public function setDslType($dslType)
    {
        if ($dslType !== 'filter' && $dslType !== 'query') {
            throw new \InvalidArgumentException('Not supported dsl type');
        }
        $this->dslType = $dslType;
    }
}
