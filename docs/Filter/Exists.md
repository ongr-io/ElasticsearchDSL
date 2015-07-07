# Exists Filter

> More info about exists filter is in the [official elasticsearch docs][1]

Returns documents that have at least one non-null value in the original field.

## Simple example

```JSON
{
    "constant_score" : {
        "filter" : {
            "exists" : { "field" : "user" }
        }
    }
}
```

And now the query via DSL:

```php
$existsFilter = new ExistsFilter('user');
$constantScoreQuery = new ConstantScoreQuery($existsFilter);

$search = new Search();
$search->addQuery($constantScoreQuery);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-exists-filter.html
