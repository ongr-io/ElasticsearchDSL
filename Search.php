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
use ONGR\ElasticsearchBundle\DSL\Highlight\Highlight;
use ONGR\ElasticsearchBundle\DSL\SearchEndpoint\SearchEndpointFactory;
use ONGR\ElasticsearchBundle\DSL\SearchEndpoint\SearchEndpointInterface;
use ONGR\ElasticsearchBundle\DSL\Sort\AbstractSort;
use ONGR\ElasticsearchBundle\DSL\Sort\Sorts;
use ONGR\ElasticsearchBundle\DSL\Suggester\AbstractSuggester;
use ONGR\ElasticsearchBundle\Serializer\Normalizer\CustomReferencedNormalizer;
use ONGR\ElasticsearchBundle\Serializer\OrderedSerializer;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;

/**
 * Search object that can be executed by a manager.
 */
class Search
{
    const SCROLL_DURATION = '5m';

    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $from;

    /**
     * @var string|null
     */
    private $scroll;

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
     * @var string[]
     */
    private $preference;

    /**
     * @var float
     */
    private $minScore;

    /**
     * @var OrderedSerializer
     */
    private $serializer;

    /**
     * @var SearchEndpointInterface[]
     */
    private $endpoints = [];

    /**
     * Initializes serializer.
     */
    public function __construct()
    {
        $this->serializer = new OrderedSerializer(
            [
                new CustomReferencedNormalizer(),
                new CustomNormalizer(),
            ]
        );
    }

    /**
     * Adds query to search.
     *
     * @param BuilderInterface $query
     * @param string           $boolType
     *
     * @return Search
     */
    public function addQuery(BuilderInterface $query, $boolType = '')
    {
        $this
            ->getEndpoint('query')
            ->addBuilder($query, ['bool_type' => $boolType]);

        return $this;
    }

    /**
     * Sets parameters for bool query.
     *
     * @param array $params Example values:
     *                      - minimum_should_match => 1
     *                      - boost => 1.
     *
     * @return Search
     */
    public function setBoolQueryParameters(array $params)
    {
        $this
            ->getEndpoint('query')
            ->setParameters($params);

        return $this;
    }

    /**
     * Returns contained query.
     *
     * @return BuilderInterface
     */
    public function getQuery()
    {
        return $this
            ->getEndpoint('query')
            ->getBuilder();
    }

    /**
     * Destroys query part.
     *
     * @return Search
     */
    public function destroyQuery()
    {
        $this->destroyEndpoint('query');

        return $this;
    }

    /**
     * Adds a filter to search.
     *
     * @param BuilderInterface $filter   Filter.
     * @param string           $boolType Possible boolType values:
     *                                   - must
     *                                   - must_not
     *                                   - should.
     *
     * @return Search
     */
    public function addFilter(BuilderInterface $filter, $boolType = '')
    {
        $this->getEndpoint('query');

        $this
            ->getEndpoint('filter')
            ->addBuilder($filter, ['bool_type' => $boolType]);

        return $this;
    }

    /**
     * Returns currently contained filters.
     *
     * @return BuilderInterface
     */
    public function getFilters()
    {
        return $this
            ->getEndpoint('filter')
            ->getBuilder();
    }

    /**
     * Sets bool filter parameters.
     *
     * @param array $params Possible values:
     *                      _cache => true
     *                      false.
     *
     * @return Search
     */
    public function setBoolFilterParameters($params)
    {
        $this
            ->getEndpoint('filter')
            ->setParameters($params);

        return $this;
    }

    /**
     * Destroys filter part.
     */
    public function destroyFilters()
    {
        $this->destroyEndpoint('filter');
    }

    /**
     * Adds a post filter to search.
     *
     * @param BuilderInterface $postFilter Post filter.
     * @param string           $boolType   Possible boolType values:
     *                                     - must
     *                                     - must_not
     *                                     - should.
     *
     * @return Search
     */
    public function addPostFilter(BuilderInterface $postFilter, $boolType = '')
    {
        $this
            ->getEndpoint('post_filter')
            ->addBuilder($postFilter, ['bool_type' => $boolType]);

        return $this;
    }

    /**
     * Returns all contained post filters.
     *
     * @return BuilderInterface
     */
    public function getPostFilters()
    {
        return $this
            ->getEndpoint('post_filter')
            ->getBuilder();
    }

    /**
     * Sets bool post filter parameters.
     *
     * @param array $params Possible values:
     *                      _cache => true
     *                      false.
     *
     * @return Search
     */
    public function setBoolPostFilterParameters($params)
    {
        $this
            ->getEndpoint('post_filter')
            ->setParameters($params);

        return $this;
    }

    /**
     * Returns min score value.
     *
     * @return float
     */
    public function getMinScore()
    {
        return $this->minScore;
    }

    /**
     * Exclude documents which have a _score less than the minimum specified.
     *
     * @param float $minScore
     *
     * @return Search
     */
    public function setMinScore($minScore)
    {
        $this->minScore = $minScore;

        return $this;
    }

    /**
     * Paginate results from.
     *
     * @param int $from
     *
     * @return Search
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Returns results offset value.
     *
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set maximum number of results.
     *
     * @param int $size
     *
     * @return Search
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Returns maximum number of results query can request.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Adds sort to search.
     *
     * @param AbstractSort $sort
     *
     * @return Search
     */
    public function addSort(AbstractSort $sort)
    {
        $this
            ->getEndpoint('sort')
            ->addBuilder($sort);

        return $this;
    }

    /**
     * Returns sorts object.
     *
     * @return Sorts
     */
    public function getSorts()
    {
        return $this
            ->getEndpoint('sort')
            ->getBuilder();
    }

    /**
     * Allows to control how the _source field is returned with every hit.
     *
     * @param array|bool|string $source
     *
     * @return Search
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Returns source value.
     *
     * @return array|bool|string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Allows to selectively load specific stored fields for each document represented by a search hit.
     *
     * @param array $fields
     *
     * @return Search
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Returns field value.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Allows to return a script evaluation (based on different fields) for each hit.
     *
     * @param array $scriptFields
     *
     * @return Search
     */
    public function setScriptFields($scriptFields)
    {
        $this->scriptFields = $scriptFields;

        return $this;
    }

    /**
     * Returns containing script fields.
     *
     * @return array
     */
    public function getScriptFields()
    {
        return $this->scriptFields;
    }

    /**
     * Allows to highlight search results on one or more fields.
     *
     * @param Highlight $highlight
     *
     * @return Search
     */
    public function setHighlight($highlight)
    {
        $this
            ->getEndpoint('highlight')
            ->addBuilder($highlight);

        return $this;
    }

    /**
     * Returns containing highlight object.
     *
     * @return Highlight
     */
    public function getHighlight()
    {
        return $this
            ->getEndpoint('highlight')
            ->getBuilder();
    }

    /**
     * Sets explain property in request body search.
     *
     * @param bool $explain
     *
     * @return Search
     */
    public function setExplain($explain)
    {
        $this->explain = $explain;

        return $this;
    }

    /**
     * Returns if explain property is set in request body search.
     *
     * @return bool
     */
    public function isExplain()
    {
        return $this->explain;
    }

    /**
     * Sets a stats group.
     *
     * @param array $stats
     *
     * @return Search
     */
    public function setStats($stats)
    {
        $this->stats = $stats;

        return $this;
    }

    /**
     * Returns a stats group.
     *
     * @return array
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * Adds aggregation into search.
     *
     * @param AbstractAggregation $aggregation
     *
     * @return Search
     */
    public function addAggregation(AbstractAggregation $aggregation)
    {
        $this
            ->getEndpoint('aggregations')
            ->addBuilder($aggregation);

        return $this;
    }

    /**
     * Returns contained aggregations.
     *
     * @return AbstractAggregation[]
     */
    public function getAggregations()
    {
        return $this
            ->getEndpoint('aggregations')
            ->getBuilder();
    }

    /**
     * Adds suggester to search.
     *
     * @param AbstractSuggester $suggester
     *
     * @return Search
     */
    public function addSuggester(AbstractSuggester $suggester)
    {
        $this
            ->getEndpoint('suggest')
            ->addBuilder($suggester);

        return $this;
    }

    /**
     * Returns all contained suggester's.
     *
     * @return AbstractSuggester[]
     */
    public function getSuggesters()
    {
        return $this
            ->getEndpoint('suggest')
            ->getBuilder();
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
        $this->scroll = $duration;

        return $this;
    }

    /**
     * Returns scroll duration.
     *
     * @return string|null
     */
    public function getScroll()
    {
        return $this->scroll;
    }

    /**
     * Set search type.
     *
     * @param string $searchType
     *
     * @return Search
     */
    public function setSearchType($searchType)
    {
        $this->searchType = $searchType;

        return $this;
    }

    /**
     * Returns search type used.
     *
     * @return string
     */
    public function getSearchType()
    {
        return $this->searchType;
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
     * @return Search
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
    public function getPreference()
    {
        return $this->preference ? implode(';', $this->preference) : null;
    }

    /**
     * Returns query url parameters.
     *
     * @return array
     */
    public function getQueryParams()
    {
        return array_filter(
            [
                'scroll' => $this->getScroll(),
                'search_type' => $this->getSearchType(),
                'preference' => $this->getPreference(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = array_filter($this->serializer->normalize($this->endpoints));

        $params = [
            'from' => 'from',
            'size' => 'size',
            'fields' => 'fields',
            'scriptFields' => 'script_fields',
            'explain' => 'explain',
            'stats' => 'stats',
            'minScore' => 'min_score',
            'source' => '_source',
        ];

        foreach ($params as $field => $param) {
            if ($this->$field !== null) {
                $output[$param] = $this->$field;
            }
        }

        return $output;
    }

    /**
     * Returns endpoint instance.
     *
     * @param string $type Endpoint type.
     *
     * @return SearchEndpointInterface
     */
    private function getEndpoint($type)
    {
        if (!array_key_exists($type, $this->endpoints)) {
            $this->endpoints[$type] = SearchEndpointFactory::get($type);
        }

        return $this->endpoints[$type];
    }

    /**
     * Destroys search endpoint.
     *
     * @param string $type Endpoint type.
     */
    private function destroyEndpoint($type)
    {
        unset($this->endpoints[$type]);
    }
}
