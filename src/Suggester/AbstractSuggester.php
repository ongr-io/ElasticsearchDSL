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

/**
 * AbstractSuggester class.
 */
abstract class AbstractSuggester implements NamedBuilderInterface
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $field
     * @param string $text
     * @param string $name
     */
    public function __construct($field, $text, $name = null)
    {
        $this->field = $field;
        $this->text = $text;

        if ($name === null) {
            $this->name = $field . '-' . $this->getType();
        } else {
            $this->name = $name;
        }
    }

    /**
     * @return string
     */
    abstract public function getType();

    /**
     * @param string $field
     *
     * @return AbstractSuggester
     */
    public function setField($field)
    {
        $this->field = $field;

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
     * @param string $text
     *
     * @return AbstractSuggester
     */
    public function setText($text)
    {
        $this->text = $text;

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
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return AbstractSuggester
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
