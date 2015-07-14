# Or Filter

> More info about or filter is in the [official elasticsearch docs][1]

A filter that matches documents using the OR boolean operator on other filters.

## Simple example

```JSON
{
    "filtered" : {
        "query" : {
            "term" : { "name.first" : "shay" }
        },
        "filter" : {
            "or" : [
                {
                    "term" : { "name.second" : "banon" }
                },
                {
                    "term" : { "name.nick" : "kimchy" }
                }
            ]
        }
    }
}
```

And now the query via DSL:

```php
$termFilter1 = new TermFilter('name.second', 'banon');
$termFilter2 = new TermFilter('name.nick', 'kimchy');

$orFilter = new OrFilter();
$orFilter->add($termFilter1);
$orFilter->add($termFilter2);

$termQuery = new TermQuery('name.first', 'shay');
$filteredQuery = new FilteredQuery($termQuery, $orFilter);

$search = new Search();
$search->addQuery($filteredQuery);
$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-or-filter.html
