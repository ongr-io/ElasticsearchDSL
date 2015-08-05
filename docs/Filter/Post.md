# Post Filter

> More info about post filter is in the [official elasticsearch docs][1]

The post filters are filters that are applied to the search hits at the very end
of a search request, after [aggregations][2] have already been calculated.

To add post filters use `addPostFilter` method in `Search` object.
`addPostFilter` works like query and filter adders - you can add as many
filters as you want and bool filter will be formed if endpoint has multiple
filters or bool type parameter was provided.

## Simple example

```JSON
{
  "post_filter": { 
    "term": { "color": "red" }
  }
}
```

And now the query via DSL:

```php
$termFilter = new TermFilter('color', 'red');

$search = new Search();
$search->addPostFilter($termFilter);
$queryArray = $search->toArray();
```

## Bool example

```JSON
{
    "post_filter": {
        "bool": {
            "must": [
                {
                    "term": {
                        "color": "red"
                    }
                },
                {
                    "term": {
                        "brand": "ana"
                    }
                }
            ]
        }
    }
}
```

And now the query via DSL:

```php
$termFilter1 = new TermFilter('color', 'red');
$termFilter2 = new TermFilter('brand', 'ana');

$search = new Search();
$search->addPostFilter($termFilter1);
$search->addPostFilter($termFilter2);
$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-post-filter.html
[2]: ../Aggregation/index.md