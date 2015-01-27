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

use ONGR\ElasticsearchBundle\DSL\NamedBuilderBag;
use ONGR\ElasticsearchBundle\DSL\NamedBuilderInterface;

/**
 * Data holder for highlight api.
 */
class Highlight extends NamedBuilderBag
{
    const TYPE_PLAIN = 'plain';
    const TYPE_POSTINGS = 'postings';
    const TYPE_FVH = 'fvh';

    /**
     * @var array Holds html tag name and class that highlight will be put in (default 'em' tag).
     */
    private $tags = [];

    /**
     * @var string Holds tag schema name. 'styled' is the only option yet.
     */
    private $tagsSchema = null;

    /**
     * @var string Fragments sort type.
     */
    private $order = null;

    /**
     * @var string Highlighter type. By default plain.
     */
    private $type = null;

    /**
     * @var int Size of the highlighted fragment in characters. By default 100.
     */
    private $fragmentSize = null;

    /**
     * @var int Maximum number of fragments to return. By default 5.
     */
    private $numberOfFragments = null;

    /**
     * {@inheritdoc}
     *
     * @return Highlight
     */
    public function add(NamedBuilderInterface $builder)
    {
        parent::add($builder);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return Highlight
     */
    public function set(array $builders)
    {
        parent::set($builders);

        return $this;
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

        /** @var NamedBuilderInterface $field */
        foreach ($this->all() as $field) {
            $highlight['fields'][$field->getName()] = $field->toArray();
        }

        return $highlight;
    }
}
