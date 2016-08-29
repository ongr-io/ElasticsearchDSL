# Max Bucket Aggregation

> More info about max bucket aggregation is in the [official elasticsearch docs][1]

A sibling pipeline aggregation which identifies the bucket(s) with the maximum value of a 
specified metric in a sibling aggregation and outputs both the value and the key(s) of the 
bucket(s). The specified metric must be numeric and the sibling aggregation must be a multi-bucket 
aggregation.

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
        "max_monthly_sales": {
            "max_bucket": {
                "buckets_path": "sales_per_month>sales" 
            }
        }
    }
}
```

And now the query via DSL:

```php
$dateAggregation = new DateHistogramAggregation('sales_per_month', 'date', 'month');
$sumAggregation = new SumAggregation('sales', 'price');
$maxBucketAggregation = new MaxBucketAggregation('max_monthly_sales', 'sales_per_month>sales');
$dateAggregation->addAggregation($sumAggregation);

$search = new Search();
$search->addAggregation($dateAggregation);
$search->addAggregation($maxBucketAggregation);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-max-bucket-aggregation.html
