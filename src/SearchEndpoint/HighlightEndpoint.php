<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\SearchEndpoint;

use ONGR\ElasticsearchDSL\BuilderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Search highlight dsl endpoint.
 */
class HighlightEndpoint implements SearchEndpointInterface
{
    use BuilderContainerAwareTrait {
        addBuilder as private traitAddBuilder;
    }

    /**
     * @var int
     */
    private $highlight;

    /**
     * {@inheritdoc}
     */
    public function normalize(NormalizerInterface $normalizer, $format = null, array $context = [])
    {
        if (!$this->getBuilder($this->highlight)) {
            return null;
        }

        return $this->getBuilder($this->highlight)->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function addBuilder(BuilderInterface $builder, $parameters = [])
    {
        if ($this->getBuilders()) {
            throw new \OverflowException('Only one highlight is expected');
        }

        $this->highlight = $this->traitAddBuilder($builder, $parameters);

        return $this->highlight;
    }
}
