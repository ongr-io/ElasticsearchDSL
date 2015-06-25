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

use ONGR\ElasticsearchDSL\Suggester\Context\AbstractContext;

/**
 * Context suggester.
 */
class Context extends AbstractSuggester
{
    /**
     * @var AbstractContext[]
     */
    private $context;

    /**
     * @var int Size of completion.
     */
    private $size;

    /**
     * Returns context.
     *
     * @return AbstractContext[]
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Sets context array.
     *
     * @param AbstractContext[] $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * Sets context.
     *
     * @param AbstractContext $context
     */
    public function addContext($context)
    {
        $this->context[] = $context;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $completion = ['field' => $this->getField()];
        foreach ($this->context as $context) {
            $completion['context'][$context->getName()] = $context->toArray();
        }
        if ($this->getSize() !== null) {
            $completion['size'] = $this->getSize();
        }

        return [
            $this->getName() => [
                'text' => $this->getText(),
                'completion' => $completion,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'completion';
    }
}
