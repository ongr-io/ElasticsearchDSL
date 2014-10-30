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

/**
 * Class representing TermsAggregation.
 */
class TermsAggregation extends AbstractAggregation
{
    use BucketingTrait;

    const MODE_COUNT = '_count';
    const MODE_TERM = '_term';
    const DIRECTION_ASC = 'asc';
    const DIRECTION_DESC = 'desc';

    /**
     * @var int
     */
    private $size;

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
    private $minDocumentCount;

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
     * Sets buckets max count.
     *
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
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
     * Sets minimum hits to consider as term.
     *
     * @param int $count
     */
    public function setMinDocumentCount($count)
    {
        $this->minDocumentCount = $count;
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
        $data = ['field' => $this->getField()];

        if ($this->orderMode && $this->orderDirection) {
            $data['order'] = [
                $this->orderMode => $this->orderDirection,
            ];
        }

        if ($this->size) {
            $data['size'] = $this->size;
        }

        if ($this->minDocumentCount) {
            $data['min_doc_count'] = $this->minDocumentCount;
        }

        $includeResult = $this->getIncludeExclude($this->include, $this->includeFlags);
        if ($includeResult) {
            $data['include'] = $includeResult;
        }

        $excludeResult = $this->getIncludeExclude($this->exclude, $this->excludeFlags);
        if ($excludeResult) {
            $data['exclude'] = $excludeResult;
        }

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
