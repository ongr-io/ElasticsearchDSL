<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Highlight;

use ONGR\ElasticsearchBundle\DSL\BuilderInterface;
use ONGR\ElasticsearchBundle\DSL\NamedBuilderInterface;

/**
 * This class holds data for highlighting field.
 */
class Field implements NamedBuilderInterface
{
    const TYPE_PLAIN = 'plain';
    const TYPE_POSTINGS = 'postings';
    const TYPE_FVH = 'fvh';

    /**
     * @var string Field name.
     */
    private $name;

    /**
     * @var string Highlighter type. By default 'plain'.
     */
    private $type;

    /**
     * @var int Size of the highlighted fragment in characters. By default 100.
     */
    private $fragmentSize;

    /**
     * @var int Maximum number of fragments to return. By default 5.
     */
    private $numberOfFragments;

    /**
     * @var array Combine matches on multiple fields to highlight a single field.
     */
    private $matchedFields;

    /**
     * @var array BuilderInterface query to highlight.
     */
    private $highlightQuery;

    /**
     * @var int Show part of string even if there are no matches to highlight. Defaults to 0.
     */
    private $noMatchSize;

    /**
     * @var bool Highlight fields based on the source.
     */
    private $forceSource;

    /**
     * Creates a highlight for a field.
     *
     * @param string $name Field name.
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->setMatchedFields([$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets highlighter type (forces). Available options 'plain', 'postings', 'fvh'.
     *
     * @param string $type
     *
     * @return Field
     */
    public function setHighlighterType($type)
    {
        $reflection = new \ReflectionClass(__CLASS__);
        if (in_array($type, $reflection->getConstants())) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Sets field fragment size.
     *
     * @param int $fragmentSize
     *
     * @return Field
     */
    public function setFragmentSize($fragmentSize)
    {
        $this->fragmentSize = $fragmentSize;

        return $this;
    }

    /**
     * Sets maximum number of fragments to return.
     *
     * @param int $numberOfFragments
     *
     * @return Field
     */
    public function setNumberOfFragments($numberOfFragments)
    {
        $this->numberOfFragments = $numberOfFragments;

        return $this;
    }

    /**
     * Set fields to match.
     *
     * @param array $matchedFields
     *
     * @return Field
     */
    public function setMatchedFields($matchedFields)
    {
        $this->matchedFields = $matchedFields;

        return $this;
    }

    /**
     * Set query to highlight.
     *
     * @param BuilderInterface $query
     *
     * @return Field
     */
    public function setHighlightQuery(BuilderInterface $query)
    {
        $this->highlightQuery = [$query->getType() => $query->toArray()];

        return $this;
    }

    /**
     * Shows set length of a string even if no matches found.
     *
     * @param int $noMatchSize
     *
     * @return Field
     */
    public function setNoMatchSize($noMatchSize)
    {
        $this->noMatchSize = $noMatchSize;

        return $this;
    }

    /**
     * Set to force highlighting from source.
     *
     * @param bool $forceSource
     *
     * @return Field
     */
    public function setForceSource($forceSource)
    {
        $this->forceSource = $forceSource;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return array_filter(
            [
                'fragment_size' => $this->fragmentSize,
                'number_of_fragments' => $this->numberOfFragments,
                'type' => $this->type,
                'matched_fields' => $this->matchedFields,
                'highlight_query' => $this->highlightQuery,
                'no_match_size' => $this->noMatchSize,
                'force_source' => $this->forceSource,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }
}
