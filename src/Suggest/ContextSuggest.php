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

class ContextSuggest implements BuilderInterface
{
    use ParametersTrait;

    const DEFAULT_SIZE = 3;

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $text;
    /**
     * @var array
     */
    private $context;

    /**
     * ContextSuggest constructor.
     * @param string $name
     * @param string $text
     * @param array $context
     * @param array $parameters
     */
    public function __construct($name, $text, $context, $parameters = [])
    {
        $this->name = $name;
        $this->text = $text;
        $this->context = $context;
        $this->setParameters($parameters);
        $this->addParameter('context', $context);
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
        return 'context_suggest';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        if (!$this->hasParameter('field')) {
            $this->addParameter('field', '_all');
        }

        if (!$this->hasParameter('size')) {
            $this->addParameter('size', self::DEFAULT_SIZE);
        }

        $output = [
            $this->name => [
                'text' => $this->text,
                'completion' => $this->getParameters(),
            ]
        ];

        return $output;
    }
}
