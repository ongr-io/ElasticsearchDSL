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

namespace ONGR\ElasticsearchDSL\SearchEndpoint;

use ONGR\ElasticsearchDSL\Suggest\TermSuggest;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SuggestEndpoint extends AbstractSearchEndpoint
{
    const NAME = 'suggest';

    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        $output = [];
        if (count($this->getAll()) > 0) {
            foreach ($this->getAll() as $suggest) {
                $output = array_merge($output, $suggest->toArray());
            }
        }

        return $output;
    }
}
