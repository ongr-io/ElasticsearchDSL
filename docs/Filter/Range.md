# Range Filter

> More info about range filter is in the [official elasticsearch docs][1]

Filters documents with fields that have terms within a certain range.

## Simple example

```JSON
{
    "filter" : {
        "range" : {
            "age" : {
                "gte": 10,
                "lte": 20
            }
        }
    }
}
```

And now the query via DSL:

```php
$rangeFilter = new RangeFilter('age', ['gte' => 10, 'lte' => 20]);

$search = new Search();
$search->addFilter($rangeFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-range-filter.html
