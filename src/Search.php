<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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
     */
    private ?bool $trackTotalHits = null;

    /**
     * To retrieve hits from a certain offset. Defaults to 0.
     *
     */
    private ?int $from = null;

    /**
     * The number of hits to return. Defaults to 10. If you do not care about getting some
     * hits back but only about the number of matches and/or aggregations, setting the value
     * to 0 will help performance.
     */
    private ?int $size = null;

    /**
     * Allows to control how the _source field is returned with every hit. By default
     * operations return the contents of the _source field unless you have used the
     * stored_fields parameter or if the _source field is disabled.
     */
    private ?bool $source = null;

    /**
     * Allows to selectively load specific stored fields for each document represented by a search hit.
     */
    private ?array $storedFields = null;

    /**
     * Allows to return a script evaluation (based on different fields) for each hit.
     * Script fields can work on fields that are not stored, and allow to return custom
     * values to be returned (the evaluated value of the script). Script fields can
     * also access the actual _source document indexed and extract specific elements
     * to be returned from it (can be an "object" type).
     */
    private ?array $scriptFields = null;

    /**
     * Allows to return the doc value representation of a field for each hit. Doc value
     * fields can work on fields that are not stored. Note that if the fields parameter
     * specifies fields without docvalues it will try to load the value from the fielddata
     * cache causing the terms for that field to be loaded to memory (cached), which will
     * result in more memory consumption.
     */
    private ?array $docValueFields = null;

    /**
     * Enables explanation for each hit on how its score was computed.
     */
    private ?bool $explain = null;

    /**
     * Returns a version for each search hit.
     */
    private ?bool $version = null;

    /**
     * Allows to configure different boost level per index when searching across more
     * than one indices. This is very handy when hits coming from one index matter more
     * than hits coming from another index (think social graph where each user has an index).
     */
    private ?array $indicesBoost = null;

    /**
     * Exclude documents which have a _score less than the minimum specified in min_score.
     */
    private ?int $minScore = null;

    /**
     * Pagination of results can be done by using the from and size but the cost becomes
     * prohibitive when the deep pagination is reached. The index.max_result_window which
     * defaults to 10,000 is a safeguard, search requests take heap memory and time
     * proportional to from + size. The Scroll api is recommended for efficient deep
     * scrolling but scroll contexts are costly and it is not recommended to use it for
     * real time user requests. The search_after parameter circumvents this problem by
     * providing a live cursor. The idea is to use the results from the previous page to
     * help the retrieval of the next page.
     */
    private ?array $searchAfter = null;

    /**
     * URI parameters alongside Request body search.
     *
     * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-uri-request.html
     */
    private array $uriParams = [];

    /**
     * While a search request returns a single “page” of results, the scroll API can be used to retrieve
     * large numbers of results (or even all results) from a single search request, in much the same way
     * as you would use a cursor on a traditional database. Scrolling is not intended for real time user
     * requests, but rather for processing large amounts of data, e.g. in order to reindex the contents
     * of one index into a new index with a different configuration.
     */
    private ?string $scroll = null;

    private static ?OrderedSerializer $serializer = null;

    private array $endpoints = [];

    public function __construct()
    {
        $this->initializeSerializer();
    }

    public function __wakeup()
    {
        $this->initializeSerializer();
    }

    private function initializeSerializer(): void
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

    public function destroyEndpoint(string $type): void
    {
        unset($this->endpoints[$type]);
    }

    public function addQuery(BuilderInterface $query, string $boolType = BoolQuery::MUST, ?string $key = null): static
    {
        $endpoint = $this->getEndpoint(QueryEndpoint::NAME);
        $endpoint->addToBool($query, $boolType, $key);

        return $this;
    }

    private function getEndpoint(string $type): SearchEndpointInterface
    {
        if (!array_key_exists($type, $this->endpoints)) {
            $this->endpoints[$type] = SearchEndpointFactory::get($type);
        }

        return $this->endpoints[$type];
    }

    public function getQueries(): BoolQuery
    {
        $endpoint = $this->getEndpoint(QueryEndpoint::NAME);

        return $endpoint->getBool();
    }

    public function setQueryParameters(array $parameters): static
    {
        $this->setEndpointParameters(QueryEndpoint::NAME, $parameters);

        return $this;
    }

    public function setEndpointParameters(string $endpointName, array $parameters): static
    {
        /** @var AbstractSearchEndpoint $endpoint */
        $endpoint = $this->getEndpoint($endpointName);
        $endpoint->setParameters($parameters);

        return $this;
    }

    public function addPostFilter(
        BuilderInterface $filter,
        string $boolType = BoolQuery::MUST,
        ?string $key = null
    ): static {
        $this
            ->getEndpoint(PostFilterEndpoint::NAME)
            ->addToBool($filter, $boolType, $key);

        return $this;
    }

    public function getPostFilters(): BoolQuery
    {
        $endpoint = $this->getEndpoint(PostFilterEndpoint::NAME);

        return $endpoint->getBool();
    }

    public function setPostFilterParameters(array $parameters): static
    {
        $this->setEndpointParameters(PostFilterEndpoint::NAME, $parameters);

        return $this;
    }

    public function addAggregation(AbstractAggregation $aggregation): static
    {
        $this->getEndpoint(AggregationsEndpoint::NAME)->add($aggregation, $aggregation->getName());

        return $this;
    }

    public function getAggregations(): array
    {
        return $this->getEndpoint(AggregationsEndpoint::NAME)->getAll();
    }

    public function addInnerHit(NestedInnerHit $innerHit): static
    {
        $this->getEndpoint(InnerHitsEndpoint::NAME)->add($innerHit, $innerHit->getName());

        return $this;
    }

    public function getInnerHits(): array
    {
        return $this->getEndpoint(InnerHitsEndpoint::NAME)->getAll();
    }

    public function addSort(BuilderInterface $sort): static
    {
        $this->getEndpoint(SortEndpoint::NAME)->add($sort);

        return $this;
    }

    public function getSorts(): array
    {
        return $this->getEndpoint(SortEndpoint::NAME)->getAll();
    }

    public function addHighlight(Highlight $highlight): static
    {
        $this->getEndpoint(HighlightEndpoint::NAME)->add($highlight);

        return $this;
    }

    public function getHighlights(): BuilderInterface
    {
        /** @var HighlightEndpoint $highlightEndpoint */
        $highlightEndpoint = $this->getEndpoint(HighlightEndpoint::NAME);

        return $highlightEndpoint->getHighlight();
    }

    public function addSuggest(NamedBuilderInterface $suggest): static
    {
        $this->getEndpoint(SuggestEndpoint::NAME)->add($suggest, $suggest->getName());

        return $this;
    }

    public function getSuggests(): array
    {
        return $this->getEndpoint(SuggestEndpoint::NAME)->getAll();
    }

    public function getFrom(): ?int
    {
        return $this->from;
    }

    public function setFrom(?int $from): static
    {
        $this->from = $from;

        return $this;
    }

    public function isTrackTotalHits(): bool
    {
        return $this->trackTotalHits;
    }

    public function setTrackTotalHits(bool $trackTotalHits): static
    {
        $this->trackTotalHits = $trackTotalHits;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function isSource(): ?bool
    {
        return $this->source;
    }

    public function setSource(?bool $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getStoredFields(): ?array
    {
        return $this->storedFields;
    }

    public function setStoredFields(?array $storedFields): static
    {
        $this->storedFields = $storedFields;

        return $this;
    }

    public function getScriptFields(): ?array
    {
        return $this->scriptFields;
    }

    public function setScriptFields(?array $scriptFields): static
    {
        $this->scriptFields = $scriptFields;

        return $this;
    }

    public function getDocValueFields(): ?array
    {
        return $this->docValueFields;
    }

    public function setDocValueFields(?array $docValueFields): static
    {
        $this->docValueFields = $docValueFields;

        return $this;
    }

    public function isExplain(): ?bool
    {
        return $this->explain;
    }

    public function setExplain(?bool $explain): static
    {
        $this->explain = $explain;

        return $this;
    }

    public function isVersion(): ?bool
    {
        return $this->version;
    }

    public function setVersion(?bool $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function getIndicesBoost(): ?array
    {
        return $this->indicesBoost;
    }

    public function setIndicesBoost(?array $indicesBoost): static
    {
        $this->indicesBoost = $indicesBoost;

        return $this;
    }

    public function getMinScore(): ?int
    {
        return $this->minScore;
    }

    public function setMinScore(?int $minScore): static
    {
        $this->minScore = $minScore;

        return $this;
    }

    public function getSearchAfter(): ?array
    {
        return $this->searchAfter;
    }

    public function setSearchAfter(?array $searchAfter): static
    {
        $this->searchAfter = $searchAfter;

        return $this;
    }

    public function getScroll(): ?string
    {
        return $this->scroll;
    }

    public function setScroll(?string $scroll = '5m'): static
    {
        $this->scroll = $scroll;

        $this->addUriParam('scroll', $this->scroll);

        return $this;
    }

    public function addUriParam(string $name, string|array|bool $value): static
    {
        if (in_array(
            $name,
            [
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
            ]
        )) {
            $this->uriParams[$name] = $value;
        } else {
            throw new \InvalidArgumentException(sprintf('Parameter %s is not supported.', $value));
        }

        return $this;
    }

    public function getUriParams(): array
    {
        return $this->uriParams;
    }

    public function toArray(): array
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
