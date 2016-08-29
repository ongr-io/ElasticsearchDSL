# Sum Bucket Aggregation

> More info about sum bucket aggregation is in the [official elasticsearch docs][1]

A sibling pipeline aggregation which calculates the sum across all bucket of a 
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
            "sum_bucket": {
                "buckets_path": "sales_per_month>sales" 
            }
        }
    }
}
```

And now the query via DSL:

```php
$dateAggregation = new DateHistogramAggregation('sales_per_month', 'date', 'month');
$dateAggregation->addAggregation(new SumAggregation('sales', 'price'));
$sumBucketAggregation = new SumBucketAggregation(
    'sum_monthly_sales', 
    'sales_per_month>sales'
)

$search = new Search();
$search->addAggregation($dateAggregation);
$search->addAggregation($sumBucketAggregation);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-sum-bucket-aggregation.html
