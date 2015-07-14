# Term Filter

> More info about term filter is in the [official elasticsearch docs][1]

Filters documents that have fields that contain a term.

## Simple example

```JSON
{
    "filter" : {
        "term" : { "user" : "kimchy"}
    }
}
```

And now the query via DSL:

```php
$termFilter = new TermFilter('user', 'kimchy');

$search = new Search();
$search->addFilter($termFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-term-filter.html
