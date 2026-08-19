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

namespace ONGR\ElasticsearchDSL\Highlight;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Data holder for highlight api.
 */
class Highlight implements BuilderInterface
{
    use ParametersTrait;

    private array $fields = [];

    private ?array $tags = null;

    public function addField(string $name, array $params = []): static
    {
        $this->fields[$name] = $params;

        return $this;
    }

    public function setTags(array $preTags, array $postTags): static
    {
        $this->tags['pre_tags'] = $preTags;
        $this->tags['post_tags'] = $postTags;

        return $this;
    }

    public function getType(): string
    {
        return 'highlight';
    }

    public function toArray(): array
    {
        $output = [];

        if (is_array($this->tags)) {
            $output = $this->tags;
        }

        $output = $this->processArray($output);

        foreach ($this->fields as $field => $params) {
            $output['fields'][$field] = count($params) ? $params : new \stdClass();
        }

        return $output;
    }
}
