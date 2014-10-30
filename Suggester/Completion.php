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
 * Completion class.
 */
class Completion extends AbstractSuggester
{
    /**
     * @var bool
     */
    private $useFuzzy = false;

    /**
     * @var int
     */
    private $fuzziness;

    /**
     * @var bool
     */
    private $transpositions;

    /**
     * @var int
     */
    private $minLength;

    /**
     * @var int
     */
    private $prefixLength;

    /**
     * @var string
     */
    private $unicodeAware;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'completion';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        if (!$this->getField() && !$this->getText()) {
            throw new \LogicException('Field and text should be defined.');
        }

        $fuzzy = array_filter(
            [
                'fuzziness' => $this->getFuzziness(),
                'transpositions' => $this->isTranspositions(),
                'min_length' => $this->getMinLength(),
                'prefix_length' => $this->getPrefixLength(),
                'unicode_aware' => $this->getUnicodeAware(),
            ]
        );

        $completion = [
            'field' => $this->getField()
        ];

        if (empty($fuzzy) && $this->isFuzzy()) {
            $completion['fuzzy'] = true;
        } elseif (!empty($fuzzy)) {
            $completion['fuzzy'] = $fuzzy;
        }

        return [
            $this->getName() => [
                'text' => $this->getText(),
                'completion' => $completion,
            ]
        ];
    }

    /**
     * @return int
     */
    public function getFuzziness()
    {
        return $this->fuzziness;
    }

    /**
     * @param int $fuzziness
     *
     * @return Completion
     */
    public function setFuzziness($fuzziness)
    {
        $this->fuzziness = $fuzziness;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinLength()
    {
        return $this->minLength;
    }

    /**
     * @param int $minLength
     *
     * @return Completion
     */
    public function setMinLength($minLength)
    {
        $this->minLength = $minLength;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrefixLength()
    {
        return $this->prefixLength;
    }

    /**
     * @param int $prefixLength
     *
     * @return Completion
     */
    public function setPrefixLength($prefixLength)
    {
        $this->prefixLength = $prefixLength;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTranspositions()
    {
        return $this->transpositions;
    }

    /**
     * @param bool $transpositions
     *
     * @return Completion
     */
    public function setTranspositions($transpositions)
    {
        $this->transpositions = $transpositions;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnicodeAware()
    {
        return $this->unicodeAware;
    }

    /**
     * @param string $unicodeAware
     *
     * @return Completion
     */
    public function setUnicodeAware($unicodeAware)
    {
        $this->unicodeAware = $unicodeAware;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFuzzy()
    {
        return $this->useFuzzy;
    }

    /**
     * Sets fuzzy and returns Completion object.
     *
     * @param bool $useFuzzy
     *
     * @return Completion
     */
    public function useFuzzy($useFuzzy)
    {
        $this->useFuzzy = $useFuzzy;

        return $this;
    }
}
