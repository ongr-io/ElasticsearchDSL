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

use ONGR\ElasticsearchDSL\NamedBuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Class Suggester.
 */
class Suggester implements NamedBuilderInterface
{
    use ParametersTrait;

    const TYPE_PHRASE = 'phrase';
    const TYPE_TERM = 'term';
    const TYPE_COMPLETION = 'completion';
    const TYPE_CONTEXT = 'completion';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string;
     */
    private $name;

    /**
     * @var ContextInterface[]
     */
    private $context = [];

    /**
     * @param string $type
     * @param string $field
     * @param string $text
     * @param array  $parameters
     * @param string $name
     */
    public function __construct($type, $field, $text, $parameters = [], $name = null)
    {
        $this
            ->setType($type)
            ->setField($field)
            ->setText($text)
            ->setName($name)
            ->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $body = ['field' => $this->getField()];

        $contexts = $this->getContext();
        if ($contexts && $this->getType() === self::TYPE_CONTEXT) {
            $body['context'] = [];
            foreach ($contexts as $context) {
                $body['context'][$context->getName()] = $context->toArray();
            }
        }

        return [
            $this->getName() => [
                'text' => $this->getText(),
                $this->getType() => $this->processArray($body),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     *
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param ContextInterface $context
     *
     * @return $this
     */
    public function addContext(ContextInterface $context)
    {
        $this->context[] = $context;

        return $this;
    }

    /**
     * @return ContextInterface[]
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param ContextInterface[] $context
     *
     * @return $this
     */
    public function setContext(array $context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Returns builder name.
     *
     * @return string
     */
    public function getName()
    {
        if (!$this->name) {
            return $this->getField() . '-' . $this->getType();
        }

        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
