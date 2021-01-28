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

namespace ONGR\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * Class representing Bucket Script Pipeline Aggregation.
 *
 * @link https://goo.gl/miVxcx
 */
class BucketScriptAggregation extends AbstractPipelineAggregation
{
    public function __construct(
        private string $name,
        private ?array $bucketsPath,
        private ?string $script = null
    ) {
        parent::__construct($name, $bucketsPath);
        $this->setScript($script);
    }

    public function getScript(): ?string
    {
        return $this->script;
    }

    public function setScript(?string $script): static
    {
        $this->script = $script;

        return $this;
    }

    public function getType(): string
    {
        return 'bucket_script';
    }

    public function getArray(): array
    {
        if (!$this->getScript()) {
            throw new \LogicException(
                sprintf(
                    '`%s` aggregation must have script set.',
                    $this->getName()
                )
            );
        }

        return [
            'buckets_path' => $this->getBucketsPath(),
            'script' => $this->getScript(),
        ];
    }
}
