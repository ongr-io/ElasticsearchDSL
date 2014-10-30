<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Suggester;

/**
 * Phrase class.
 */
class Phrase extends AbstractSuggester
{
    /**
     * @var string
     */
    private $analyzer;

    /**
     * @var int
     */
    private $gramSize;

    /**
     * @var float
     */
    private $realWordErrorLikelihood;

    /**
     * @var float
     */
    private $confidence;

    /**
     * @var float
     */
    private $maxErrors;

    /**
     * @var array
     */
    private $highlight = [];

    /**
     * @var int
     */
    private $size;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'phrase';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        if (!$this->getField() && !$this->getText()) {
            throw new \LogicException('Field and text should be defined.');
        }

        $phrase = [
            'field' => $this->getField(),
            'analyzer' => $this->getAnalyzer(),
            'size' => $this->getSize(),
            'real_word_error_likelihood' => $this->getRealWordErrorLikelihood(),
            'max_errors' => $this->getMaxErrors(),
            'gram_size' => $this->getGramSize(),
        ];

        if ($this->getHighlight()) {
            $phrase['highlight'] = (object)$this->getHighlight();
        }

        return [
            $this->getName() => [
                'text' => $this->getText(),
                'phrase' => array_filter($phrase),
            ]
        ];
    }

    /**
     * @return string
     */
    public function getAnalyzer()
    {
        return $this->analyzer;
    }

    /**
     * @param string $analyzer
     *
     * @return Phrase
     */
    public function setAnalyzer($analyzer)
    {
        $this->analyzer = $analyzer;

        return $this;
    }

    /**
     * @return float
     */
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * @param float $confidence
     *
     * @return Phrase
     */
    public function setConfidence($confidence)
    {
        $this->confidence = $confidence;

        return $this;
    }

    /**
     * @return int
     */
    public function getGramSize()
    {
        return $this->gramSize;
    }

    /**
     * @param int $gramSize
     *
     * @return Phrase
     */
    public function setGramSize($gramSize)
    {
        $this->gramSize = $gramSize;

        return $this;
    }

    /**
     * @return array
     */
    public function getHighlight()
    {
        return $this->highlight;
    }

    /**
     * @param array $highlight
     *
     * @return Phrase
     */
    public function setHighlight($highlight)
    {
        $this->highlight = $highlight;

        return $this;
    }

    /**
     * @return float
     */
    public function getMaxErrors()
    {
        return $this->maxErrors;
    }

    /**
     * @param float $maxErrors
     *
     * @return Phrase
     */
    public function setMaxErrors($maxErrors)
    {
        $this->maxErrors = $maxErrors;

        return $this;
    }

    /**
     * @return float
     */
    public function getRealWordErrorLikelihood()
    {
        return $this->realWordErrorLikelihood;
    }

    /**
     * @param float $realWordErrorLikelihood
     *
     * @return Phrase
     */
    public function setRealWordErrorLikelihood($realWordErrorLikelihood)
    {
        $this->realWordErrorLikelihood = $realWordErrorLikelihood;

        return $this;
    }

    /**
     * @param int $size
     *
     * @return Phrase
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }
}
