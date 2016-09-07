# Percentiles Bucket Aggregation

> More info about avg bucket aggregation is in the [official elasticsearch docs][1]

A sibling pipeline aggregation which calculates percentiles across all bucket of a 
specified metric in a sibling aggregation. The specified metric must be numeric and 
the sibling aggregation must be a multi-bucket aggregation.

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
        "sum_monthly_sales": {
            "percentiles_bucket": {
                "buckets_path": "sales_per_month>sales", 
                "percents": [ 25.0, 50.0, 75.0 ] 
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
$percentilesAggregation = new AvgBucketAggregation('sum_monthly_sales', 'sales_per_month>sales')
$percentilesAggregation->setPercentiles([25.0, 50.0, 75.0]);

$search->addAggregation($dateAggregation);
$search->addAggregation($percentilesAggregation);

$aggArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-percentiles-bucket-aggregation.html