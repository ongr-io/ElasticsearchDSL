# Query

Objective query builder represents all available [Elasticsearch queries][1].

To form a query you have to create `Search` object. See below an example of match all query usage.

```php
$search = new Search();
$matchAllQuery = new MatchAllQuery();
$search->addQuery($matchAllQuery);
$queryArray = $search->toArray();
```

```php
//$queryArray content
'query' =>
    [
      'match_all' => \stdClass(),
    ]
```

So now you can easily pass it to the elasticsearch-php client:

```php
//from elasticsearch/elasticsearch package
$client = new Elasticsearch\Client();

$searchParams = [
  'index' => 'people',
  'type' => 'person',
  'body' => $queryArray
];

$docs = $client->search($searchParams);
```
> This example works with elasticsearch/elasticsearch ~1.0 version.


## Queries:
 - [Bool](Bool.md)
 - [Boosting](Boosting.md)
 - [Common terms](CommonTerms.md)
 - [Constant Score](ConstantScore.md)
 - [DisMax](DisMax.md)
 - [Filtered](Filtered.md)
 - [Function score](FunctionScore.md)
 - [Fuzzy](Fuzzy.md)
 - [Fuzzy like this field](FuzzyLikeThisField.md)
 - [Fuzzy like this query](FuzzyLikeThisQuery.md)
 - [Has child](HasChild.md)
 - [Has parent](HasParent.md)
 - [Ids](Ids.md)
 - [Indices](Indices.md)
 - [Match all](MatchAll.md)
 - [Match](Match.md)
 - [More like this](MoreLikeThis.md)
 - [Multi match](MultiMatch.md)
 - [Nested](Nested.md)
 - [Prefix](Prefix.md)
 - [Query string](QueryString.md)
 - [Range](Range.md)
 - [Simple query string](SimpleQueryString.md)
 - [Term](Term.md)
 - [Terms](Terms.md)
 - [Wildcard](Wildcard.md)

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-queries.html
