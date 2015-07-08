# Type Filter

> More info about type filter is in the [official elasticsearch docs][1]

Filters documents matching the provided document / mapping type.

## Simple example

```JSON
{
    "type" : {
        "value" : "my_type"
    }
}
```

And now the query via DSL:

```php
$typeFilter = new TypeFilter('my_type');

$search = new Search();
$search->addFilter($typeFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-type-filter.html
