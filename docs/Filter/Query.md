# Query Filter

> More info about query filter is in the [official elasticsearch docs][1]

Wraps any query to be used as a filter.

## Simple example

```JSON
{
    "filter" : {
        "query" : {
            "query_string" : {
                "query" : "this AND that OR thus"
            }
        }
    }
}
```

And now the query via DSL:

```php
$queryStringQuery = new QueryStringQuery('this AND that OR thus');
$queryFilter = new QueryFilter($queryStringQuery);

$search = new Search();
$search->addFilter($queryFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-query-filter.html
