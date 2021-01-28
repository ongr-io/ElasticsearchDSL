<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Serializer\Normalizer;

use ONGR\ElasticsearchDSL\ParametersTrait;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

abstract class AbstractNormalizable implements NormalizableInterface
{
    use ParametersTrait {
        ParametersTrait::hasParameter as hasReference;
        ParametersTrait::getParameter as getReference;
        ParametersTrait::getParameters as getReferences;
        ParametersTrait::addParameter as addReference;
        ParametersTrait::removeParameter as removeReference;
        ParametersTrait::setParameters as setReferences;
    }
}
