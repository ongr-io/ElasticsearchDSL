# And query

> More info about Boosting query is in the [official elasticsearch docs][1]

A query that matches documents using the AND boolean operator on other queries.
Lets take an example to write a query with Elasticsearch DSL.

```JSON
{
    "query" : {
        "and" : [
            {
                "range" : {
                    "postDate" : {
                        "from" : "2010-03-01",
                        "to" : "2010-04-01"
                    }
                }
            },
            {
                "prefix" : { "name.second" : "ba" }
            }
        ]
    }
}
```

And now the query via DSL:

```php
$query1 = new RangeQuery(
    'postDate',
    ['from' => '2010-03-01', 'to' => '2010-04-01']
);
$query2 = new PrefixQuery('name.second', "ba");

$andQuery = new AndQuery([$query1, $query2]);

$search = new Search();
$search->addQuery($andQuery);

$queryArray = $search->toArray();
```


[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-and-query.html
