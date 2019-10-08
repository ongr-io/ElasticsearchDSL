<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Suggest;

use ONGR\ElasticsearchDSL\NamedBuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;

class Suggest implements NamedBuilderInterface
{
    use ParametersTrait;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $field;

    /**
     * TermSuggest constructor.
     * @param string $name
     * @param string $type
     * @param string $text
     * @param string $field
     * @param array $parameters
     */
    public function __construct($name, $type, $text, $field, $parameters = [])
    {
        $this->setName($name);
        $this->setType($type);
        $this->setText($text);
        $this->setField($field);
        $this->setParameters($parameters);
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

    /**
     * Returns suggest name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns element type.
     *
     * @return string
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
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = [
            $this->getName() => [
                'text' => $this->getText(),
                $this->getType() => $this->processArray(['field' => $this->getField()]),
            ]
        ];

        return $output;
    }
}
