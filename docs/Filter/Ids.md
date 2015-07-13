# Ids Filter

> More info about ids filter is in the [official elasticsearch docs][1]

Filters documents that only have the provided ids.

## Simple example

```JSON
{
    "ids" : {
        "type" : "my_type",
        "values" : ["1", "4", "100"]
    }
}
```

And now the query via DSL:

```php
$idsFilters = new IdsFilter(
    ['1', '4', '100'],
    ['type' => 'my_type']
);

$search = new Search();
$search->addFilter($idsFilters);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-ids-filter.html
