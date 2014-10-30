<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DSL;

use ONGR\ElasticsearchBundle\DSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchBundle\DSL\Aggregation\Aggregations;
use ONGR\ElasticsearchBundle\DSL\Bool\Bool;
use ONGR\ElasticsearchBundle\DSL\Filter\PostFilter;
use ONGR\ElasticsearchBundle\DSL\Highlight\Highlight;
use ONGR\ElasticsearchBundle\DSL\Query\FilteredQuery;
use ONGR\ElasticsearchBundle\DSL\Query\Query;
use ONGR\ElasticsearchBundle\DSL\Sort\AbstractSort;
use ONGR\ElasticsearchBundle\DSL\Sort\Sorts;
use ONGR\ElasticsearchBundle\DSL\Suggester\AbstractSuggester;
use ONGR\ElasticsearchBundle\DSL\Suggester\Suggesters;

/**
 * Search object that can be executed by a manager.
 */
class Search
{
    const SCROLL_DURATION = '5m';

    /**
     * @var Query $query
     */
    private $query;

    /**
     * @var array
     */
    private $boolQueryParams;

    /**
     * @var BuilderInterface $filters
     */
    private $filters;

    /**
     * Filters collection.
     *
     * @var BuilderInterface $postFilters
     */
    private $postFilters;

    /**
     * @var array
     */
    private $boolFilterParams;

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $from;

    /**
     * @var Sorts
     */
    private $sorts;

    /**
     * @var string|null
     */
    private $scrollDuration;

    /**
     * @var array|bool|string
     */
    private $source;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var array
     */
    private $scriptFields;

    /**
     * @var Suggesters
     */
    private $suggesters;

    /**
     * @var Highlight
     */
    private $highlight;

    /**
     * @var string
     */
    private $searchType;

    /**
     * @var bool
     */
    private $explain;

    /**
     * @var array
     */
    private $stats;

    /**
     * @var Aggregations
     */
    private $aggregations;

    /**
     * @var string[]
     */
    private $preference;

    /**
     * Set offset.
     *
     * @param int $from
     *
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set maximum number of results.
     *
     * @param int $size
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Add sort.
     *
     * @param AbstractSort $sort
     *
     * @return $this
     */
    public function addSort($sort)
    {
        if ($this->sorts === null) {
            $this->sorts = new Sorts();
        }

        $this->sorts->addSort($sort);

        return $this;
    }

    /**
     * Set source.
     *
     * @param array|bool|string $source
     *
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Set fields.
     *
     * @param array $fields
     *
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Set script fields.
     *
     * @param array $scriptFields
     *
     * @return $this
     */
    public function setScriptFields($scriptFields)
    {
        $this->scriptFields = $scriptFields;

        return $this;
    }

    /**
     * @param BuilderInterface $postFilter Post filter.
     * @param string           $boolType   Possible boolType values:
     *                                     - must
     *                                     - must_not
     *                                     - should.
     *
     * @return $this
     */
    public function addPostFilter(BuilderInterface $postFilter, $boolType = 'must')
    {
        if ($this->postFilters === null) {
            $this->postFilters = new Bool();
        }

        $this->postFilters->addToBool($postFilter, $boolType);

        return $this;
    }

    /**
     * Sets highlight.
     *
     * @param Highlight $highlight
     *
     * @return $this
     */
    public function setHighlight($highlight)
    {
        $this->highlight = $highlight;

        return $this;
    }

    /**
     * Set search type.
     *
     * @param string $searchType
     *
     * @return $this
     */
    public function setSearchType($searchType)
    {
        $this->searchType = $searchType;

        return $this;
    }

    /**
     * Set explain.
     *
     * @param bool $explain
     *
     * @return $this
     */
    public function setExplain($explain)
    {
        $this->explain = $explain;

        return $this;
    }

    /**
     * Set stats.
     *
     * @param array $stats
     *
     * @return $this
     */
    public function setStats($stats)
    {
        $this->stats = $stats;

        return $this;
    }

    /**
     * Setter for scroll duration, effectively setting if search is scrolled or not.
     *
     * @param string|null $duration
     *
     * @return Search
     */
    public function setScroll($duration = self::SCROLL_DURATION)
    {
        $this->scrollDuration = $duration;

        return $this;
    }

    /**
     * Setter for preference.
     *
     * Controls which shard replicas to execute the search request on.
     *
     * @param mixed $preferenceParams Possible values:
     *                                _primary
     *                                _primary_first
     *                                _local
     *                                _only_node:xyz (xyz - node id)
     *                                _prefer_node:xyz (xyz - node id)
     *                                _shards:2,3 (2 and 3 specified shards)
     *                                custom value
     *                                string[] combination of params.
     *
     * @return Search $this
     */
    public function setPreference($preferenceParams)
    {
        if (is_string($preferenceParams)) {
            $this->preference[] = $preferenceParams;
        }

        if (is_array($preferenceParams) && !empty($preferenceParams)) {
            $this->preference = $preferenceParams;
        }

        return $this;
    }

    /**
     * Returns preference params as string.
     *
     * @return string
     */
    protected function getPreference()
    {
        return implode(';', $this->preference);
    }

    /**
     * Returns scroll duration.
     *
     * @return null|string
     */
    public function getScroll()
    {
        return $this->scrollDuration;
    }

    /**
     * @param AbstractAggregation $agg
     *
     * @return $this
     */
    public function addAggregation($agg)
    {
        if ($this->aggregations === null) {
            $this->aggregations = new Aggregations();
        }
        $this->aggregations->addAggregation($agg);

        return $this;
    }

    /**
     * @param BuilderInterface $filter   Filter.
     * @param string           $boolType Possible boolType values:
     *                                   - must
     *                                   - must_not
     *                                   - should.
     *
     * @return $this
     */
    public function addFilter(BuilderInterface $filter, $boolType = 'must')
    {
        if ($this->filters === null) {
            $this->filters = new Bool();
        }

        $this->filters->addToBool($filter, $boolType);

        return $this;
    }

    /**
     * @param array $params Possible values:
     *                      _cache => true
     *                      false.
     */
    public function setBoolFilterParameters($params)
    {
        $this->boolFilterParams = $params;
    }

    /**
     * @param AbstractSuggester $suggester
     *
     * @return Search
     */
    public function addSuggester(AbstractSuggester $suggester)
    {
        if ($this->suggesters === null) {
            $this->suggesters = new Suggesters();
        }
        $this->suggesters->add($suggester);

        return $this;
    }

    /**
     * @param BuilderInterface $query    Query.
     * @param string           $boolType Possible boolType values:
     *                                   - must
     *                                   - must_not
     *                                   - should.
     *
     * @return $this
     */
    public function addQuery(BuilderInterface $query, $boolType = 'must')
    {
        if ($this->query === null) {
            $this->query = new Query;
        }
        $this->query->addQuery($query, $boolType);

        return $this;
    }

    /**
     * Unset the query.
     */
    public function destroyQuery()
    {
        $this->query = null;
    }

    /**
     * @param array $params Example values:
     *                      - minimum_should_match => 1
     *                      - boost => 1.
     */
    public function setBoolQueryParameters(array $params)
    {
        $this->query->setBoolParameters($params);
    }

    /**
     * Returns query string parameters.
     *
     * @return array
     */
    public function getQueryParams()
    {
        $array = [];

        if ($this->scrollDuration !== null) {
            $array['scroll'] = $this->scrollDuration;
        }

        if ($this->searchType !== null) {
            $array['search_type'] = $this->searchType;
        }

        if ($this->preference !== null) {
            $array['preference'] = $this->getPreference();
        }

        return $array;
    }

    /**
     * @return Aggregations
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @return array
     */
    public function getBoolFilterParameters()
    {
        return $this->boolFilterParams;
    }

    /**
     * @return array
     */
    public function getBoolQueryParameters()
    {
        return $this->boolQueryParams;
    }

    /**
     * @return bool
     */
    public function isExplain()
    {
        return $this->explain;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return BuilderInterface[]
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return Highlight
     */
    public function getHighlight()
    {
        return $this->highlight;
    }

    /**
     * @return BuilderInterface
     */
    public function getPostFilters()
    {
        return $this->postFilters;
    }

    /**
     * @return BuilderInterface[]
     */
    public function getQueries()
    {
        return $this->queries;
    }

    /**
     * @return array
     */
    public function getScriptFields()
    {
        return $this->scriptFields;
    }

    /**
     * @return null|string
     */
    public function getScrollDuration()
    {
        return $this->scrollDuration;
    }

    /**
     * @return string
     */
    public function getSearchType()
    {
        return $this->searchType;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return Sorts
     */
    public function getSorts()
    {
        return $this->sorts;
    }

    /**
     * @return array|bool|string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return array
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @return Suggesters
     */
    public function getSuggesters()
    {
        return $this->suggesters;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = [];

        if ($this->filters !== null) {
            if ($this->query === null) {
                $queryForFiltered = null;
            } else {
                $queryForFiltered = clone $this->query;
            }

            $filteredQuery = new FilteredQuery($queryForFiltered);
            $filteredQuery->setFilter($this->filters);

            if ($this->boolFilterParams) {
                $filteredQuery->setBoolParameters($this->boolFilterParams);
            }

            $this->destroyQuery();
            $this->addQuery($filteredQuery);
        }

        if ($this->query !== null) {
            $output[$this->query->getType()] = $this->query->toArray();
        }

        if ($this->postFilters !== null) {
            $postFilter = new PostFilter();
            $postFilter->setFilter($this->postFilters);

            $output[$postFilter->getType()] = $postFilter->toArray();
        }

        if ($this->highlight !== null) {
            $output['highlight'] = $this->highlight->toArray();
        }

        $params = [
            'from' => 'from',
            'size' => 'size',
            'fields' => 'fields',
            'scriptFields' => 'script_fields',
            'explain' => 'explain',
            'stats' => 'stats',
        ];

        foreach ($params as $field => $param) {
            if ($this->$field !== null) {
                $output[$param] = $this->$field;
            }
        }

        if ($this->sorts && $this->sorts->isRelevant()) {
            $output[$this->sorts->getType()] = $this->sorts->toArray();
        }

        if ($this->source !== null) {
            $output['_source'] = $this->source;
        }

        if ($this->aggregations !== null) {
            $aggregationsOutput = [];
            foreach ($this->aggregations->all() as $aggregation) {
                $aggregationsOutput = array_merge($aggregationsOutput, $aggregation->toArray());
            }

            if (!empty($aggregationsOutput)) {
                $output['aggregations'] = $aggregationsOutput;
            }
        }

        if ($this->suggesters !== null) {
            $suggestersOutput = [];
            foreach ($this->suggesters->all() as $suggester) {
                $suggestersOutput = array_merge($suggestersOutput, $suggester->toArray());
            }

            if (!empty($suggestersOutput)) {
                $output['suggest'] = $suggestersOutput;
            }
        }

        return $output;
    }
}
