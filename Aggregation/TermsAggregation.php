<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL\Aggregation;

use ONGR\ElasticsearchBundle\DSL\Aggregation\Type\BucketingTrait;
use ONGR\ElasticsearchBundle\DSL\ScriptAwareTrait;

/**
 * Class representing TermsAggregation.
 */
class TermsAggregation extends AbstractAggregation
{
    use BucketingTrait;
    use ScriptAwareTrait;

    const DIRECTION_ASC = 'asc';
    const DIRECTION_DESC = 'desc';
    const HINT_MAP = 'map';
    const HINT_GLOBAL_ORDINALS = 'global_ordinals';
    const HINT_GLOBAL_ORDINALS_HASH = 'global_ordinals_hash';
    const HINT_GLOBAL_ORDINALS_LOW_CARDINALITY = 'global_ordinals_low_cardinality';
    const COLLECT_BREADTH_FIRST = 'breadth_first';
    const COLLECT_DEPTH_FIRST = 'depth_first';

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $shardSize;

    /**
     * @var int
     */
    private $shardMinDocCount;

    /**
     * @var string
     */
    private $executionHint;

    /**
     * @var string
     */
    private $orderMode;

    /**
     * @var string
     */
    private $orderDirection;

    /**
     * @var int
     */
    private $minDocCount;

    /**
     * @var string
     */
    private $include;

    /**
     * @var string
     */
    private $includeFlags;

    /**
     * @var string
     */
    private $exclude;

    /**
     * @var string
     */
    private $excludeFlags;

    /**
     * @var string
     */
    private $collectMode;

    /**
     * @return string
     */
    public function getCollectMode()
    {
        return $this->collectMode;
    }

    /**
     * @param string $collectMode
     */
    public function setCollectMode($collectMode = self::COLLECT_DEPTH_FIRST)
    {
        $this->collectMode = $collectMode;
    }

    /**
     * @return int
     */
    public function getShardSize()
    {
        return $this->shardSize;
    }

    /**
     * @param int $shardSize
     */
    public function setShardSize($shardSize)
    {
        $this->shardSize = $shardSize;
    }

    /**
     * @return int
     */
    public function getShardMinDocCount()
    {
        return $this->shardMinDocCount;
    }

    /**
     * @param int $shardMinDocCount
     */
    public function setShardMinDocCount($shardMinDocCount)
    {
        $this->shardMinDocCount = $shardMinDocCount;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Sets buckets max count.
     *
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getExecutionHint()
    {
        return $this->executionHint;
    }

    /**
     * @param string $executionHint
     */
    public function setExecutionHint($executionHint = self::HINT_MAP)
    {
        $this->executionHint = $executionHint;
    }

    /**
     * Sets buckets ordering.
     *
     * @param string $mode
     * @param string $direction
     */
    public function setOrder($mode, $direction = self::DIRECTION_ASC)
    {
        $this->orderMode = $mode;
        $this->orderDirection = $direction;
    }

    /**
     * @return array|null
     */
    public function getOrder()
    {
        if ($this->isOrder()) {
            return [$this->orderMode => $this->orderDirection];
        }

        return null;
    }

    /**
     * @return bool
     */
    private function isOrder()
    {
        return $this->orderMode && $this->orderDirection;
    }

    /**
     * @return int
     */
    public function getMinDocCount()
    {
        return $this->minDocCount;
    }

    /**
     * Sets minimum hits to consider as term.
     *
     * @param int $minDocCount
     */
    public function setMinDocCount($minDocCount)
    {
        $this->minDocCount = $minDocCount;
    }

    /**
     * Sets include field.
     *
     * @param string $include Include field.
     * @param string $flags   Possible flags:
     *                        - CANON_EQ
     *                        - CASE_INSENSITIVE
     *                        - COMMENTS
     *                        - DOTALL
     *                        - LITERAL
     *                        - MULTILINE
     *                        - UNICODE
     *                        - UNICODE_CASE
     *                        - UNICODE_CHARACTER_CLASS
     *                        - UNIX_LINES
     *                        Usage example:
     *                        'CASE_INSENSITIVE|MULTILINE'.
     */
    public function setInclude($include, $flags = '')
    {
        $this->include = $include;
        $this->includeFlags = $flags;
    }

    /**
     * Sets include field.
     *
     * @param string $exclude
     * @param string $flags
     *
     * @see Terms::setInclude()
     */
    public function setExclude($exclude, $flags = '')
    {
        $this->exclude = $exclude;
        $this->excludeFlags = $flags;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $data = array_filter(
            [
                'field' => $this->getField(),
                'min_doc_count' => $this->getMinDocCount(),
                'size' => $this->getSize(),
                'shard_size' => $this->getShardSize(),
                'shard_min_doc_count' => $this->getShardMinDocCount(),
                'order' => $this->getOrder(),
                'include' => $this->getIncludeExclude($this->include, $this->includeFlags),
                'exclude' => $this->getIncludeExclude($this->exclude, $this->excludeFlags),
                'execution_hint' => $this->getExecutionHint(),
                'script' => $this->getScript(),
                'collect_mode' => $this->getCollectMode(),
            ],
            function ($value) {
                return ($value || $value !== null);
            }
        );

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'terms';
    }

    /**
     * Constructs include/exclude search values.
     *
     * @param string $pattern
     * @param string $flags
     *
     * @return string|array|null
     */
    protected function getIncludeExclude($pattern, $flags)
    {
        if ($pattern) {
            if (empty($flags)) {
                return $pattern;
            } else {
                return [
                    'pattern' => $pattern,
                    'flags' => $flags,
                ];
            }
        }

        return null;
    }
}
