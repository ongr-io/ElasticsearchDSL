<?php

namespace ONGR\ElasticsearchDSL\Query\Specialized;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "template" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-template-query.html
 */
class TemplateQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private ?string $file = null,
        private ?string $inline = null,
        private array $params = []
    ) {
        $this->setFile($file);
        $this->setInline($inline);
        $this->setParams($params);
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): static
    {
        $this->file = $file;

        return $this;
    }

    public function getInline(): ?string
    {
        return $this->inline;
    }

    public function setInline(?string $inline): static
    {
        $this->inline = $inline;

        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams(array $params): static
    {
        $this->params = $params;

        return $this;
    }

    public function getType(): string
    {
        return 'template';
    }

    public function toArray(): array
    {
        $output = array_filter(
            [
                'file' => $this->getFile(),
                'inline' => $this->getInline(),
                'params' => $this->getParams(),
            ]
        );

        if (!isset($output['file']) && !isset($output['inline'])) {
            throw new \InvalidArgumentException(
                'Template query requires that either `inline` or `file` parameters are set'
            );
        }

        $output = $this->processArray($output);

        return [$this->getType() => $output];
    }
}
