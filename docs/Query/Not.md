# Not query

> More info about Boosting query is in the [official elasticsearch docs][1]

A query that filters out matched documents using a query. For example:

```JSON
{
    "bool" : {
        "must" : {
            "term" : { "name.first" : "shay" }
        },
        "filter" : {
            "not" : {
                "range" : {
                    "postDate" : {
                        "from" : "2010-03-01",
                        "to" : "2010-04-01"
                    }
                }
            }
        }
    }
}
```

And now the query via DSL:

```php

$queryRange = new RangeQuery(
    'postDate',
    ['from' => '2010-03-01', 'to' => '2010-04-01']
);
$queryTerm = new TermQuery('name.first', 'shay');

$queryNot = new NotQuery($queryRange);

$bool = new BoolQuery();
$bool->add($queryTerm, BoolQuery::MUST);
$bool->add($queryNot, BoolQuery::FILTER);

```


[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-not-query.html
