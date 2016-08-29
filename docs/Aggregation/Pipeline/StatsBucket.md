# Stats Aggregation

> More info about stats bucket aggregation is in the [official elasticsearch docs][1]

A sibling pipeline aggregation which calculates a variety of stats across all bucket of 
a specified metric in a sibling aggregation. The specified metric must be numeric and the 
sibling aggregation must be a multi-bucket aggregation.

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
            "stats_bucket": {
                "buckets_path": "sales_per_month>sales" 
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
    new StatsBucketAggregation('stats_monthly_sales', 'sales_per_month>sales')
);

$aggArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-stats-bucket-aggregation.html