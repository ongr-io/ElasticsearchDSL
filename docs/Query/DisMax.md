# Dis Max query

> More info about Dis Max query is in the [official elasticsearch docs][1]

A query that generates the union of documents produced by its subqueries, and that scores each document with the
maximum score for that document as produced by any subquery, plus a tie breaking increment for any additional matching
subqueries.

Lets try to write this example
```JSON
{
    "dis_max" : {
        "tie_breaker" : 0.7,
        "boost" : 1.2,
        "queries" : [
            {
                "term" : { "age" : 34 }
            },
            {
                "term" : { "age" : 35 }
            }
        ]
    }
}
```

In DSL :

```php
$term1 = new TermQuery('age', 34);
$term2 = new TermQuery('age', 35);

$disMax = new DisMaxQuery();
$disMax->addParameter('tie_breaker', 0.7);
$disMax->addParameter('boost', 1.2);
$disMax->addQuery($term1);
$disMax->addQuery($term2);

$search = new Search();
$search->addQuery($disMax);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-dis-max-query.html
