# Limit Filter

> More info about limit filter is in the [official elasticsearch docs][1]

A limit filter limits the number of documents (per shard) to execute on.

## Simple example

```JSON
{
    "filtered" : {
        "filter" : {
             "limit" : {"value" : 100}
         },
         "query" : {
            "term" : { "name.first" : "shay" }
        }
    }
}
```

And now the query via DSL:

```php
$limitFilter = new LimitFilter(100);
$termQuery = new TermQuery('name.first', 'shay');

$filteredQuery = new FilteredQuery($termQuery, $limitFilter);

$search = new Search();
$search->addQuery($filteredQuery);
$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-limit-filter.html
