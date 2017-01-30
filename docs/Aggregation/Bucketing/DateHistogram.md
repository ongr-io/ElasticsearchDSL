# Date Histogram Aggregation

> More info about histogram aggregation is in the [official elasticsearch docs][1]

A multi-bucket aggregation similar to the histogram except it can only be applied on date values.
Example of expressions for interval: `year`, `quarter`, `month`, `week`, `day`, `hour`, `minute`, `second`

## Simple example

```JSON
{
    "aggregations": {
        "articles_over_time" : {
            "date_histogram" : {
                "field" : "date",
                "interval" : "month"
            }
        }
    }
}
```

And now the query via DSL:

```php
$dateHistogramAggregation = new DateHistogramAggregation('articles_over_time', 'date', 'month');

$search = new Search();
$search->addAggregation($dateHistogramAggregation);

$queryArray = $search->toArray();
```

## Adding parameters example

Additional parameters can be added to the aggregation. In the following example we will demonstrate how
to provide a custom format to the results of the query:

```JSON
{
    "aggregations": {
        "articles_over_time" : {
            "date_histogram" : {
                "field" : "date",
                "interval" : "1M",
                "format" : "yyyy-MM-dd"
            }
        }
    }
}
```

And now the query via DSL:

```php

$dateHistogramAggregation = new DateHistogramAggregation('articles_over_time', 'date', 'month');
$dateHistogramAggregation->addParameter('format', 'yyyy-MM-dd');

$search = new Search();
$search->addAggregation($dateHistogramAggregation);

$queryArray = $search->toArray();

```
[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-datehistogram-aggregation.html