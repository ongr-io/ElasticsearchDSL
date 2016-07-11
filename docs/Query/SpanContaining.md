# Span Containing query

> More info about Boosting query is in the [official elasticsearch docs][1]

Returns matches which enclose another span query.

```JSON
{
    "span_containing" : {
        "little" : {
            "span_term" : { "field1" : "foo" }
        },
        "big" : {
            "span_near" : {
                "clauses" : [
                    { "span_term" : { "field1" : "bar" } },
                    { "span_term" : { "field1" : "baz" } }
                ],
                "slop" : 5,
                "in_order" : true
            }
        }
    }
}
```

And now the query via DSL:

```php
$spanTermQuery = new SpanTermQuery('field1', 'foo');
$spanNearQuery = new SpanNearQuery();

$spanNearQuery->setSlop(5);
$spanNearQuery->addParameter('in_order', true);
$spanNearQuery->addQuery(new SpanTermQuery('field1', 'bar'));
$spanNearQuery->addQuery(new SpanTermQuery('field1', 'baz'));

$spanContainingQuery = new SpanContainingQuery(
    $spanTermQuery,
    $spanNearQuery
);
```


[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-containing-query.html
