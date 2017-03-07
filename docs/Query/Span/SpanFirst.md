# Span First Query

> More info about Span First query is in the [official elasticsearch docs][1]

Matches spans near the beginning of a field. The span first query maps to Lucene SpanFirstQuery. Here is an example:

```JSON
{
    "query": {
        "span_first" : {
            "match" : {
                "span_term" : { "user" : "kimchy" }
            },
            "end" : 3
        }
    }
}
```

And now the query via DSL:

```php
$search = new Search();
$query = new SpanFirstQuery(new SpanTermQuery('user', 'kimchy'), 3);
$search->addQuery($query);

$search->toArray();
```


[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-first-query.html
