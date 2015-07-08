# Match All Filter

> More info about match all filter is in the [official elasticsearch docs][1]

A filter that matches on all documents.

## Simple example

```JSON
{
    "filter" : {
        "match_all" : { }
    }
}
```

And now the query via DSL:

```php
$matchAllFilter = new MatchAllFilter();

$search = new Search();
$search->addFilter($matchAllFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-indices-filter.html
