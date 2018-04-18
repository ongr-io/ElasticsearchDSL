# Span Near Query

> More info about span near query is in the [official elasticsearch docs][1]

Matches spans which are near one another. One can specify slop, the maximum number of intervening unmatched positions, as well as whether matches are required to be in-order. The span near query maps to Lucene SpanNearQuery. Here is an example:

## Simple example

```JSON
{
    "query": {
        "span_near" : {
            "clauses" : [
                { "span_term" : { "field" : "value1" } },
                { "span_term" : { "field" : "value2" } },
                { "span_term" : { "field" : "value3" } }
            ],
            "slop" : 12,
            "in_order" : false
        }
    }
}
```

In DSL:

```php
$search = new Search();
$spanNearQuery = new SpanNearQuery();
$spanNearQuery->addQuery(new SpanTermQuery('field', 'value1'));
$spanNearQuery->addQuery(new SpanTermQuery('field', 'value2'));
$spanNearQuery->addQuery(new SpanTermQuery('field', 'value3'));
$spanNearQuery->addParameter('slop', 12);
$spanNearQuery->addParameter('in_order', false);
$search->addQuery($spanNearQuery);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-near-query.html
