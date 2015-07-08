# Avg Aggregation

> More info about avg aggregation is in the [official elasticsearch docs][1]

A single-value metrics aggregation that computes the average of numeric values that are extracted from the aggregated documents.


## Simple example

```JSON
{
    "aggregations": {
        "agg_avg_grade": {
            "avg": {
                "field": "grade"
            }
        }
    }
}
```

And now the query via DSL:

```php
$avgAggregation = new AvgAggregation('avg_grade');
$avgAggregation->setField('grade');

$search = new Search();
$search->addAggregation($avgAggregation);

$queryArray = $search->toArray();
```

There is also an exception due adding queries to the search. If you add only one query without type it will form simple query. e.g. lets try to create match all query.

```php
$search = new Search();
$matchAllQuery = new MatchAllQuery();
$search->addQuery($matchAllQuery);
$queryArray = $search->toArray();
```

You will get this query:
```JSON
{
    "query": {
        "match_all": {}
    }
}
```

> More info about `Search` look in the [How to search](../HowTo/HowToSearch.md) chapter.



[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-avg-aggregation.html