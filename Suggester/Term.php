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
 * Term class.
 */
class Term extends AbstractSuggester
{
    const SORT_BY_SCORE = 'score';
    const SORT_BY_FREQ = 'frequency';
    const SUGGEST_MODE_MISSING = 'missing';
    const SUGGEST_MODE_POPULAR = 'popular';
    const SUGGEST_MODE_ALWAYS = 'always';

    /**
     * @var string
     */
    private $sort;

    /**
     * @var string
     */
    private $analyzer;

    /**
     * @var string;
     */
    private $suggestMode;

    /**
     * @var int
     */
    private $size;

    /**
     * @return string
     */
    public function getType()
    {
        return 'term';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        if (!$this->getField() && !$this->getText()) {
            throw new \LogicException('Field and text should be defined.');
        }

        $suggester = array_filter(
            [
                'field' => $this->getField(),
                'analyzer' => $this->getAnalyzer(),
                'sort' => $this->getSort(),
                'suggest_mode' => $this->getSuggestMode(),
            ]
        );

        return [
            $this->getName() => array_filter(
                [
                    'text' => $this->getText(),
                    'size' => $this->getSize(),
                    'term' => $suggester,
                ]
            ),
        ];
    }

    /**
     * @return string
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param string $sort
     *
     * @return Term
     */
    public function setSort($sort)
    {
        if (in_array(
            $sort,
            [
                self::SORT_BY_FREQ,
                self::SORT_BY_SCORE,
            ]
        )
        ) {
            $this->sort = $sort;
        }

        return $this;
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
     * @return Term
     */
    public function setAnalyzer($analyzer)
    {
        $this->analyzer = $analyzer;

        return $this;
    }

    /**
     * @return string
     */
    public function getSuggestMode()
    {
        return $this->suggestMode;
    }

    /**
     * @param string $suggestMode
     *
     * @return Term
     */
    public function setSuggestMode($suggestMode)
    {
        if (in_array(
            $suggestMode,
            [
                self::SUGGEST_MODE_ALWAYS,
                self::SUGGEST_MODE_MISSING,
                self::SUGGEST_MODE_POPULAR,
            ]
        )
        ) {
            $this->suggestMode = $suggestMode;
        }

        return $this;
    }

    /**
     * @param int $size
     *
     * @return Term
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
