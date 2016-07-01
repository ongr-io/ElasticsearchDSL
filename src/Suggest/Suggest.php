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

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;

class Suggest implements BuilderInterface
{
    use ParametersTrait;

    const TERM = 'term';
    const COMPLETION = 'completion';
    const PHRASE = 'phrase';
    const CONTEXT = 'completion';

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
    private $field;

    /**
     * @var string
     */
    private $text;

    /**
     * TermSuggest constructor.
     * @param string $name
     * @param string $field
     * @param string $type
     * @param string $text
     * @param array $parameters
     */
    public function __construct($name, $field, $type, $text, $parameters = [])
    {
        $this->setName($name);
        $this->validateType($type);
        $this->setField($field);
        $this->setType($type);
        $this->setText($text);
        $this->setParameters($parameters);
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
     */
    public function setType($type)
    {
        $this->type = $type;
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
     */
    public function setText($text)
    {
        $this->text = $text;
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
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Checks if the type is valid
     *
     * @param string $type
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    private function validateType($type)
    {
        if (in_array($type, [
            self::COMPLETION,
            self::CONTEXT,
            self::PHRASE,
            self::TERM
        ])) {
            return true;
        }
        throw new InvalidArgumentException(
            'You must provide a valid type to the Suggest()'
        );
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
