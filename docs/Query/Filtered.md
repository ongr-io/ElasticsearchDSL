# Filtered query

> More info about filtered query is in the [official elasticsearch docs][1]

The filtered query is used to combine another query with any filter. Filters are usually faster than queries.

Lets try to write this example
```JSON
{
    "filtered": {
        "query": {
            "match": { "tweet": "full text search" }
        },
        "filter": {
            "range": { "created": { "gte": "now - 1d / d" }}
        }
    }
}
```

In DSL:

```php
$matchQuery = new MatchQuery('tweet', 'full text search');
$rangeFilter = new RangeFilter('created', ['gte' => 'now - 1d / d']);

$filteredQuery = new FilteredQuery($matchQuery, $rangeFilter);

$search = new Search();
$search->addQuery($filteredQuery);

$queryArray = $search->toArray();
```

Or:

```php
$matchQuery = new MatchQuery('tweet', 'full text search');
$rangeFilter = new RangeFilter('created', ['gte' => 'now - 1d / d']);

$filteredQuery = new FilteredQuery();
$filteredQuery->setQuery($matchQuery);
$filteredQuery->setFilter($rangeFilter);

$search = new Search();
$search->addQuery($filteredQuery);

$queryArray = $search->toArray();
```

Multiple queries and filters can be used with help off [Bool Query][2] and [Bool Filter][3] respectively.

If query is not set it defaults to Match all, thus Filtered query can be used as filter in places where query is
expected.

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-filtered-query.html
[2]: Bool.md
[3]: ../Filter/Bool.md
