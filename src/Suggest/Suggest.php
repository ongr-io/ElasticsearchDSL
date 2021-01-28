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

namespace ONGR\ElasticsearchDSL\Suggest;

use ONGR\ElasticsearchDSL\NamedBuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

class Suggest implements NamedBuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private string $name,
        private string $type,
        private string $text,
        private string $field,
        array $parameters = []
    ) {
        $this->setName($name);
        $this->setType($type);
        $this->setText($text);
        $this->setField($field);
        $this->setParameters($parameters);
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }


    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(string $field): static
    {
        $this->field = $field;

        return $this;
    }

    public function toArray(): array
    {
        return [
            $this->getName() => [
                'text' => $this->getText(),
                $this->getType() => $this->processArray(['field' => $this->getField()]),
            ]
        ];
    }
}
