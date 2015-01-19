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

/**
 * Data holder for highlight api.
 */
class Highlight
{
    const TYPE_PLAIN = 'plain';
    const TYPE_POSTINGS = 'postings';
    const TYPE_FVH = 'fvh';

    /**
     * @var array Holds fields to highlight.
     */
    protected $fields = [];

    /**
     * @var array Holds html tag name and class that highlight will be put in (default 'em' tag).
     */
    protected $tags = [];

    /**
     * @var string Holds tag schema name. 'styled' is the only option yet.
     */
    protected $tagsSchema = null;

    /**
     * @var string Fragments sort type.
     */
    protected $order = null;

    /**
     * @var string Highlighter type. By default plain.
     */
    protected $type = null;

    /**
     * @var int Size of the highlighted fragment in characters. By default 100.
     */
    protected $fragmentSize = null;

    /**
     * @var int Maximum number of fragments to return. By default 5.
     */
    protected $numberOfFragments = null;

    /**
     * Adds field to highlight.
     *
     * @param Field $field
     *
     * @return Highlight
     */
    public function addField(Field $field)
    {
        if (!$this->hasField($field->getName())) {
            $this->fields[] = $field;
        }

        return $this;
    }

    /**
     * Checks if field already will be highlighted.
     *
     * @param string $fieldName
     *
     * @return bool
     */
    public function hasField($fieldName)
    {
        /** @var Field $field */
        foreach ($this->fields as $field) {
            if ($field->getName() == $fieldName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Removes field from highlighting.
     *
     * @param string $fieldName
     *
     * @return Highlight
     */
    public function removeField($fieldName)
    {
        /** @var Field $field */
        foreach ($this->fields as $key => $field) {
            if ($field->getName() == $fieldName) {
                unset($this->fields[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Returns all fields to highlight.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Sets html tag and its class used in highlighting.
     *
     * @param string $tag
     * @param string $class
     *
     * @return Highlight
     */
    public function setTag($tag, $class = null)
    {
        $this->tags[] = array_filter(
            [
                'tag' => $tag,
                'class' => $class,
            ]
        );

        return $this;
    }

    /**
     * Sets html tag and its class used in highlighting.
     *
     * @param string $tagsSchema
     *
     * @return Highlight
     */
    public function setTagsSchema($tagsSchema)
    {
        $this->tagsSchema = $tagsSchema;

        return $this;
    }

    /**
     * Sets fragments sort order.
     *
     * @param string $order
     *
     * @return Highlight
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Sets highlighter type (forces). Available options plain, postings, fvh.
     *
     * @param string $type
     *
     * @return Highlight
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
     * @return Highlight
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
     * @return Highlight
     */
    public function setNumberOfFragments($numberOfFragments)
    {
        $this->numberOfFragments = $numberOfFragments;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $highlight = array_filter(
            [
                'order' => $this->order,
                'type' => $this->type,
                'fragment_size' => $this->fragmentSize,
                'number_of_fragments' => $this->numberOfFragments,
                'tags_schema' => $this->tagsSchema,
            ]
        );

        foreach ($this->tags as $tag) {
            if (isset($tag['tag'])) {
                $highlight['post_tags'][] = sprintf('</%s>', $tag['tag']);

                if (isset($tag['class'])) {
                    $highlight['pre_tags'][] = sprintf('<%s class="%s">', $tag['tag'], $tag['class']);
                } else {
                    $highlight['pre_tags'][] = sprintf('<%s>', $tag['tag']);
                }
            }
        }

        /** @var Field $field */
        foreach ($this->getFields() as $field) {
            $highlight['fields'][$field->getName()] = $field->toArray();
        }

        return $highlight;
    }
}
