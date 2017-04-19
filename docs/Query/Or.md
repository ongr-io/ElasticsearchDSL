# Or query

> More info about Boosting query is in the [official elasticsearch docs][1]

A query that matches documents using the OR boolean operator on other queries.
Lets take an example to write a query with Elasticsearch DSL.

```JSON
{
    "query" : {
        "or" : [
            {
                "term" : { "name.second" : "banon" }
            },
            {
                "term" : { "name.nick" : "kimchy" }
            }
        ]
    }
}
```

And now the query via DSL:

```php
$query1 = new TermQuery('name.second', 'banon');
$query2 = new TermQuery('name.nick' : 'kimchy');

$orQuery = new OrQuery([$query1, $query2]);

$search = new Search();
$search->addQuery($orQuery);

$queryArray = $search->toArray();
```


[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-or-query.html
