# Missing Filter

> More info about missing filter is in the [official elasticsearch docs][1]

Returns documents that have only null values or no value in the original field.

## Simple example

```JSON
{
    "filter" : {
        "missing" : { "field" : "user" }
    }
}
```

And now the query via DSL:

```php
$missingFilter = new MissingFilter('user');

$search = new Search();
$search->addFilter($missingFilter);

$queryArray = $search->toArray();
```

[1]: hhttps://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-missing-filter.html
