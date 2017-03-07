# Span Multi Term Query

> More info about span multi term query is in the [official elasticsearch docs][1]

The span_multi query allows you to wrap a multi term query (one of wildcard, fuzzy, prefix, range or regexp query) as a span query, so it can be nested. Example:

## Simple example

```JSON
{
    "query": {
        "span_multi":{
            "match":{
                "prefix" : { "user" :  { "value" : "ki" } }
            }
        }
    }
}
```

In DSL:

```php
$search = new Search();
$query = new PrefixQuery('user', 'ki');
$spanMultiTermQuery = new SpanMultiTermQuery($query);
$search->addQuery($spanMultiTermQuery);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-multi-term-query.html
