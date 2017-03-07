# How to search with Elasticsearch DSL

In this chapter we will take a look how to perform a search via objective way with Elasticsearch DSL. Well, the good news is that is very simple. That's why we created this library ;).

To start a search you have to create a `Search` object.

```php
$search = new Search();
```

> We won't include namespaces in any examples. Don't worry all class's names are unique, so any IDE editor should autocomplete and include it for you ;).

So, when we have a `Search` object we can start adding something to it. Usually you will add `Query` and `Aggregation`.

> More info how create [queries](../Query/index.md) and [aggregations](../Aggregation/index.md) objects.

### Form a Query

Lets take a simple query example with `MatchAllQuery`.

```php
$matchAllQuery = new MatchAllQuery();
```

To add query to the `Search` simply call `addQuery` function.

```php
$search->addQuery($matchAllQuery);
```

At the end it will form this query:

```JSON
{
  "query": {
      "match_all": {}
  }
}
```


> There is no limits to add queries or filters or anything.

### Form a Filter

Since Elasticsearch 5.0 the support for top level filters was dropped. The same functionality
is now supported via `BoolQuery`. Adding a filter to the bool query is done like so:
 
```php
$search = new Search();
$boolQuery = new BoolQuery();
$boolQuery->add(new MatchAllQuery());
$geoQuery = new TermQuery('field', 'value');
$boolQuery->add($geoQuery, BoolQuery::FILTER);
$search->addQuery($boolQuery);

$search->toArray();
```

This will result in

```
{
    "query": {
        "bool": {
            "must": [
                {
                    "match_all": {}
                }
            ],
            "filter": [
                {
                    "term": {
                        "field": "value"
                    }
                }
            ]
        }
    }
}
```

### Multiple queries and filters

As you know there is possible to use multiple filters and queries in elasticsearch. No problem, if you have several filters just add it to the search. `ElasticsearchDSL` will form a `Bool` query or filter for you when you add more than one.

Lets take an example with `Query`:

```php
$search = new Search();
$termQueryForTag1 = new TermQuery("tag", "wow");
$termQueryForTag2 = new TermQuery("tag", "elasticsearch");
$termQueryForTag3 = new TermQuery("tag", "dsl");

$search->addQuery($termQueryForTag1);
$search->addQuery($termQueryForTag2);
$search->addQuery($termQueryForTag3, BoolQuery::SHOULD);
```
The query will look like:

```JSON
{
  "query": {
    "bool": {
        "must": [
            {
                "term": { "tag": "wow" }
            },
            {
                "term": { "tag": "elasticsearch" }
            }
        ]
        "should": [
            {
                "term": { "tag": "dsl" }
            }
        ]
    }
  }
}
```
> More info how to form bool queries find in [Bool Query](../Query/Bool.md) chapter.

### Modify queries




### Sent request to the elasticsearch
And finally we can pass it to `elasticsearch-php` client. To generate an array for the client we call `toArray()` function.

```php
//from elasticsearch/elasticsearch package
$client = ClientBuilder::create()->build();

$searchParams = [
  'index' => 'people',
  'type' => 'person',
  'body' => $search->toArray(),
];

$docs = $client->search($searchParams);
```

> This example is for elasticsearch/elasticsearch ~5.0 version.
