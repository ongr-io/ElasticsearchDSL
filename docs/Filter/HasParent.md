# Has Parent Filter

> More info about has parent filter is in the [official elasticsearch docs][1]

The has parent filter accepts a query and a parent type.
The query is executed in the parent document space, which is specified by the parent type.
This filter returns child documents which associated parents have matched.

## Simple example

```JSON
{
    "has_child" : {
        "type" : "blog_tag",
        "query" : {
            "term" : {
                "tag" : "something"
            }
        }
    }
}
```

And now the query via DSL:

```php
$termQuery = new TermQuery('tag', 'something');
$hasParentFilter = new HasParentFilter(
    'blog',
    $termQuery
);

$search = new Search();
$search->addFilter($hasParentFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-has-parent-filter.html
