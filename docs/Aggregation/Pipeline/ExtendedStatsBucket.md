# Extended Stats Bucket Aggregation

> More info about extended stats bucket aggregation is in the [official elasticsearch docs][1]

This aggregation provides a few more statistics (sum of squares, standard deviation, etc) compared to the stats_bucket` aggregation.

## Simple example

```JSON
{
    "aggs" : {
        "sales_per_month" : {
            "date_histogram" : {
                "field" : "date",
                "interval" : "month"
            },
            "aggs": {
                "sales": {
                    "sum": {
                        "field": "price"
                    }
                }
            }
        },
        "stats_monthly_sales": {
            "extended_stats_bucket": {
                "buckets_paths": "sales_per_month>sales" 
            }
        }
    }
}
```

And now the query via DSL:

```php
$search = new Search();

$dateAggregation = new DateHistogramAggregation('sales_per_month', 'date', 'month');
$dateAggregation->addAggregation(
    new SumAggregation('sales', 'price')
);

$search->addAggregation($dateAggregation);
$search->addAggregation(
    new ExtendedStatsBucketAggregation('stats_monthly_sales', 'sales_per_month>sales')
);

$aggArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-extended-stats-bucket-aggregation.html