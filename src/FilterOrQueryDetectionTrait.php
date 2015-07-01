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
 * A trait which can detect query or filter is passed.
 */
trait FilterOrQueryDetectionTrait
{
    /**
     * Detects a dsl type.
     *
     * @param BuilderInterface $object
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function detectDslType(BuilderInterface $object)
    {
        $namespace = get_class($object);

        $dslTypes = ['Filter', 'Query'];

        foreach ($dslTypes as $type) {
            $length = strlen($type);
            $dslType = substr($namespace, -$length);
            if ($dslType === $type) {
                return strtolower($dslType);
            }
        }

        throw new \InvalidArgumentException();
    }
}
