# Indices Filter

> More info about indices filter is in the [official elasticsearch docs][1]

The indices filter can be used when executed across multiple indices,
allowing to have a filter that executes only when executed on an index
that matches a specific list of indices, and another filter that
executes when it is executed on an index that does not match the listed
indices.

## Simple example

```JSON
{
    "indices" : {
        "indices" : ["index1", "index2"],
        "filter" : {
            "term" : { "tag" : "wow" }
        },
        "no_match_filter" : {
            "term" : { "tag" : "kow" }
        }
    }
}
```

And now the query via DSL:

```php
$termFilter1 = new TermFilter('tag', 'wow');
$termFilter2 = new TermFilter('tag', 'kow');

$indicesFilter = new IndicesFilter(
    ['index1', 'index2'],
    $termFilter1,
    $termFilter2
);

$search = new Search();
$search->addFilter($indicesFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-indices-filter.html
