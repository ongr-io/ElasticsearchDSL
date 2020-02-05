<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Highlight\Highlight;
use ONGR\ElasticsearchDSL\InnerHit\NestedInnerHit;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\SearchEndpoint\AbstractSearchEndpoint;
use ONGR\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint;
use ONGR\ElasticsearchDSL\SearchEndpoint\HighlightEndpoint;
use ONGR\ElasticsearchDSL\SearchEndpoint\InnerHitsEndpoint;
use ONGR\ElasticsearchDSL\SearchEndpoint\PostFilterEndpoint;
use ONGR\ElasticsearchDSL\SearchEndpoint\QueryEndpoint;
use ONGR\ElasticsearchDSL\SearchEndpoint\SearchEndpointFactory;
use ONGR\ElasticsearchDSL\SearchEndpoint\SearchEndpointInterface;
use ONGR\ElasticsearchDSL\SearchEndpoint\SortEndpoint;
use ONGR\ElasticsearchDSL\Serializer\Normalizer\CustomReferencedNormalizer;
use ONGR\ElasticsearchDSL\Serializer\OrderedSerializer;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use ONGR\ElasticsearchDSL\SearchEndpoint\SuggestEndpoint;

/**
 * Search object that can be executed by a manager.
 */
class Search
{
    /**
     * If you don’t need to track the total number of hits at all you can improve
     * query times by setting this option to false. Defaults to true.
     *
     * @var bool
     */
    private $trackTotalHits;

    /**
     * To retrieve hits from a certain offset. Defaults to 0.
     *
     * @var int
     */
    private $from;

    /**
     * The number of hits to return. Defaults to 10. If you do not care about getting some
     * hits back but only about the number of matches and/or aggregations, setting the value
     * to 0 will help performance.
     *
     * @var int
     */
    private $size;

    /**
     * Allows to control how the _source field is returned with every hit. By default
     * operations return the contents of the _source field unless you have used the
     * stored_fields parameter or if the _source field is disabled.
     *
     * @var bool
     */
    private $source;

    /**
     * Allows to selectively load specific stored fields for each document represented by a search hit.
     *
     * @var array
     */
    private $storedFields;

    /**
     * Allows to return a script evaluation (based on different fields) for each hit.
     * Script fields can work on fields that are not stored, and allow to return custom
     * values to be returned (the evaluated value of the script). Script fields can
     * also access the actual _source document indexed and extract specific elements
     * to be returned from it (can be an "object" type).
     *
     * @var array
     */
    private $scriptFields;

    /**
     * Allows to return the doc value representation of a field for each hit. Doc value
     * fields can work on fields that are not stored. Note that if the fields parameter
     * specifies fields without docvalues it will try to load the value from the fielddata
     * cache causing the terms for that field to be loaded to memory (cached), which will
     * result in more memory consumption.
     *
     * @var array
     */
    private $docValueFields;

    /**
     * Enables explanation for each hit on how its score was computed.
     *
     * @var bool
     */
    private $explain;

    /**
     * Returns a version for each search hit.
     *
     * @var bool
     */
    private $version;

    /**
     * Allows to configure different boost level per index when searching across more
     * than one indices. This is very handy when hits coming from one index matter more
     * than hits coming from another index (think social graph where each user has an index).
     *
     * @var array
     */
    private $indicesBoost;

    /**
     * Exclude documents which have a _score less than the minimum specified in min_score.
     *
     * @var int
     */
    private $minScore;

    /**
     * Pagination of results can be done by using the from and size but the cost becomes
     * prohibitive when the deep pagination is reached. The index.max_result_window which
     * defaults to 10,000 is a safeguard, search requests take heap memory and time
     * proportional to from + size. The Scroll api is recommended for efficient deep
     * scrolling but scroll contexts are costly and it is not recommended to use it for
     * real time user requests. The search_after parameter circumvents this problem by
     * providing a live cursor. The idea is to use the results from the previous page to
     * help the retrieval of the next page.
     *
     * @var array
     */
    private $searchAfter;

    /**
     * URI parameters alongside Request body search.
     *
     * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-uri-request.html
     *
     * @var array
     */
    private $uriParams = [];

    /**
     * While a search request returns a single “page” of results, the scroll API can be used to retrieve
     * large numbers of results (or even all results) from a single search request, in much the same way
     * as you would use a cursor on a traditional database. Scrolling is not intended for real time user
     * requests, but rather for processing large amounts of data, e.g. in order to reindex the contents
     * of one index into a new index with a different configuration.
     *
     * @var string
     */
    private $scroll;

    /**
     * @var OrderedSerializer
     */
    private static $serializer;

    /**
     * @var SearchEndpointInterface[]
     */
    private $endpoints = [];

    /**
     * Constructor to initialize static properties
     */
    public function __construct()
    {
        $this->initializeSerializer();
    }

    /**
     * Wakeup method to initialize static properties
     */
    public function __wakeup()
    {
        $this->initializeSerializer();
    }

    /**
     * Initializes the serializer
     */
    private function initializeSerializer()
    {
        if (static::$serializer === null) {
            static::$serializer = new OrderedSerializer(
                [
                    new CustomReferencedNormalizer(),
                    new CustomNormalizer(),
                ]
            );
        }
    }

    /**
     * Destroys search endpoint.
     *
     * @param string $type Endpoint type.
     */
    public function destroyEndpoint($type)
    {
        unset($this->endpoints[$type]);
    }

    /**
     * Adds query to the search.
     *
     * @param BuilderInterface $query
     * @param string           $boolType
     * @param string           $key
     *
     * @return $this
     */
    public function addQuery(BuilderInterface $query, $boolType = BoolQuery::MUST, $key = null)
    {
        $endpoint = $this->getEndpoint(QueryEndpoint::NAME);
        $endpoint->addToBool($query, $boolType, $key);

        return $this;
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
     * Returns queries inside BoolQuery instance.
     *
     * @return BoolQuery
     */
    public function getQueries()
    {
        $endpoint = $this->getEndpoint(QueryEndpoint::NAME);

        return $endpoint->getBool();
    }

    /**
     * Sets query endpoint parameters.
     *
     * @param array $parameters
     *
     * @return $this
     */
    public function setQueryParameters(array $parameters)
    {
        $this->setEndpointParameters(QueryEndpoint::NAME, $parameters);

        return $this;
    }

    /**
     * Sets parameters to the endpoint.
     *
     * @param string $endpointName
     * @param array  $parameters
     *
     * @return $this
     */
    public function setEndpointParameters($endpointName, array $parameters)
    {
        /** @var AbstractSearchEndpoint $endpoint */
        $endpoint = $this->getEndpoint($endpointName);
        $endpoint->setParameters($parameters);

        return $this;
    }

    /**
     * Adds a post filter to search.
     *
     * @param BuilderInterface $filter   Filter.
     * @param string           $boolType Example boolType values:
     *                                   - must
     *                                   - must_not
     *                                   - should.
     * @param string           $key
     *
     * @return $this.
     */
    public function addPostFilter(BuilderInterface $filter, $boolType = BoolQuery::MUST, $key = null)
    {
        $this
            ->getEndpoint(PostFilterEndpoint::NAME)
            ->addToBool($filter, $boolType, $key);

        return $this;
    }

    /**
     * Returns queries inside BoolFilter instance.
     *
     * @return BoolQuery
     */
    public function getPostFilters()
    {
        $endpoint = $this->getEndpoint(PostFilterEndpoint::NAME);

        return $endpoint->getBool();
    }

    /**
     * Sets post filter endpoint parameters.
     *
     * @param array $parameters
     *
     * @return $this
     */
    public function setPostFilterParameters(array $parameters)
    {
        $this->setEndpointParameters(PostFilterEndpoint::NAME, $parameters);

        return $this;
    }

    /**
     * Adds aggregation into search.
     *
     * @param AbstractAggregation $aggregation
     *
     * @return $this
     */
    public function addAggregation(AbstractAggregation $aggregation)
    {
        $this->getEndpoint(AggregationsEndpoint::NAME)->add($aggregation, $aggregation->getName());

        return $this;
    }

    /**
     * Returns all aggregations.
     *
     * @return BuilderInterface[]
     */
    public function getAggregations()
    {
        return $this->getEndpoint(AggregationsEndpoint::NAME)->getAll();
    }

    /**
     * Adds inner hit into search.
     *
     * @param NestedInnerHit $innerHit
     *
     * @return $this
     */
    public function addInnerHit(NestedInnerHit $innerHit)
    {
        $this->getEndpoint(InnerHitsEndpoint::NAME)->add($innerHit, $innerHit->getName());

        return $this;
    }

    /**
     * Returns all inner hits.
     *
     * @return BuilderInterface[]
     */
    public function getInnerHits()
    {
        return $this->getEndpoint(InnerHitsEndpoint::NAME)->getAll();
    }

    /**
     * Adds sort to search.
     *
     * @param BuilderInterface $sort
     *
     * @return $this
     */
    public function addSort(BuilderInterface $sort)
    {
        $this->getEndpoint(SortEndpoint::NAME)->add($sort);

        return $this;
    }

    /**
     * Returns all set sorts.
     *
     * @return BuilderInterface[]
     */
    public function getSorts()
    {
        return $this->getEndpoint(SortEndpoint::NAME)->getAll();
    }

    /**
     * Allows to highlight search results on one or more fields.
     *
     * @param Highlight $highlight
     *
     * @return $this.
     */
    public function addHighlight($highlight)
    {
        $this->getEndpoint(HighlightEndpoint::NAME)->add($highlight);

        return $this;
    }

    /**
     * Returns highlight builder.
     *
     * @return BuilderInterface
     */
    public function getHighlights()
    {
        /** @var HighlightEndpoint $highlightEndpoint */
        $highlightEndpoint = $this->getEndpoint(HighlightEndpoint::NAME);

        return $highlightEndpoint->getHighlight();
    }

    /**
    * Adds suggest into search.
    *
    * @param BuilderInterface $suggest
    *
    * @return $this
    */
    public function addSuggest(NamedBuilderInterface $suggest)
    {
        $this->getEndpoint(SuggestEndpoint::NAME)->add($suggest, $suggest->getName());

        return $this;
    }

    /**
    * Returns all suggests.
    *
    * @return BuilderInterface[]
    */
    public function getSuggests()
    {
        return $this->getEndpoint(SuggestEndpoint::NAME)->getAll();
    }

    /**
     * @return null|int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param null|int $from
     *
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTrackTotalHits()
    {
        return $this->trackTotalHits;
    }

    /**
     * @param bool $trackTotalHits
     *
     * @return $this
     */
    public function setTrackTotalHits(bool $trackTotalHits)
    {
        $this->trackTotalHits = $trackTotalHits;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param null|int $size
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSource()
    {
        return $this->source;
    }

    /**
     * @param bool $source
     *
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return array
     */
    public function getStoredFields()
    {
        return $this->storedFields;
    }

    /**
     * @param array $storedFields
     *
     * @return $this
     */
    public function setStoredFields($storedFields)
    {
        $this->storedFields = $storedFields;

        return $this;
    }

    /**
     * @return array
     */
    public function getScriptFields()
    {
        return $this->scriptFields;
    }

    /**
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
     * @return array
     */
    public function getDocValueFields()
    {
        return $this->docValueFields;
    }

    /**
     * @param array $docValueFields
     *
     * @return $this
     */
    public function setDocValueFields($docValueFields)
    {
        $this->docValueFields = $docValueFields;

        return $this;
    }

    /**
     * @return bool
     */
    public function isExplain()
    {
        return $this->explain;
    }

    /**
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
     * @return bool
     */
    public function isVersion()
    {
        return $this->version;
    }

    /**
     * @param bool $version
     *
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return array
     */
    public function getIndicesBoost()
    {
        return $this->indicesBoost;
    }

    /**
     * @param array $indicesBoost
     *
     * @return $this
     */
    public function setIndicesBoost($indicesBoost)
    {
        $this->indicesBoost = $indicesBoost;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinScore()
    {
        return $this->minScore;
    }

    /**
     * @param int $minScore
     *
     * @return $this
     */
    public function setMinScore($minScore)
    {
        $this->minScore = $minScore;

        return $this;
    }

    /**
     * @return array
     */
    public function getSearchAfter()
    {
        return $this->searchAfter;
    }

    /**
     * @param array $searchAfter
     *
     * @return $this
     */
    public function setSearchAfter($searchAfter)
    {
        $this->searchAfter = $searchAfter;

        return $this;
    }

    /**
     * @return string
     */
    public function getScroll()
    {
        return $this->scroll;
    }

    /**
     * @param string $scroll
     *
     * @return $this
     */
    public function setScroll($scroll = '5m')
    {
        $this->scroll = $scroll;

        $this->addUriParam('scroll', $this->scroll);

        return $this;
    }

    /**
     * @param string $name
     * @param string|array|bool $value
     *
     * @return $this
     */
    public function addUriParam($name, $value)
    {
        if (in_array($name, [
            'q',
            'df',
            'analyzer',
            'analyze_wildcard',
            'default_operator',
            'lenient',
            'explain',
            '_source',
            '_source_exclude',
            '_source_include',
            'stored_fields',
            'sort',
            'track_scores',
            'timeout',
            'terminate_after',
            'from',
            'size',
            'search_type',
            'scroll',
            'allow_no_indices',
            'ignore_unavailable',
            'typed_keys',
            'pre_filter_shard_size',
            'ignore_unavailable',
        ])) {
            $this->uriParams[$name] = $value;
        } else {
            throw new \InvalidArgumentException(sprintf('Parameter %s is not supported.', $value));
        }

        return $this;
    }

    /**
     * Returns query url parameters.
     *
     * @return array
     */
    public function getUriParams()
    {
        return $this->uriParams;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $output = array_filter(static::$serializer->normalize($this->endpoints));

        $params = [
            'from' => 'from',
            'size' => 'size',
            'source' => '_source',
            'storedFields' => 'stored_fields',
            'scriptFields' => 'script_fields',
            'docValueFields' => 'docvalue_fields',
            'explain' => 'explain',
            'version' => 'version',
            'indicesBoost' => 'indices_boost',
            'minScore' => 'min_score',
            'searchAfter' => 'search_after',
            'trackTotalHits' => 'track_total_hits',
        ];

        foreach ($params as $field => $param) {
            if ($this->$field !== null) {
                $output[$param] = $this->$field;
            }
        }

        return $output;
    }
}
