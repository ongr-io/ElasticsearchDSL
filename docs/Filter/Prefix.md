# Prefix Filter

> More info about prefix filter is in the [official elasticsearch docs][1]

Filters documents that have fields containing terms with a specified prefix.

## Simple example

```JSON
{
    "filter" : {
        "prefix" : { "user" : "ki" }
    }
}
```

And now the query via DSL:

```php
$termFilter = new PrefixFilter('user', 'ki');

$search = new Search();
$search->addFilter($termFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-prefix-filter.html
