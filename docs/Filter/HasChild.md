# Has Child Filter

> More info about has child filter is in the [official elasticsearch docs][1]

The has child filter accepts a query and the child type to run against,
and results in parent documents that have child docs matching the query.

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
$hasChildFilter = new HasChildFilter(
    'blog_tag',
    $termQuery
);

$search = new Search();
$search->addFilter($hasChildFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-has-child-filter.html
