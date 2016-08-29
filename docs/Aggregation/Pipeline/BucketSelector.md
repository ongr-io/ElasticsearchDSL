# Bucket Selector Aggregation

> More info bucket selector aggregation is in the [official elasticsearch docs][1]

A parent pipeline aggregation which executes a script which determines whether the 
current bucket will be retained in the parent multi-bucket aggregation. The specified 
metric must be numeric and the script must return a boolean value. If the script 
language is expression then a numeric return value is permitted. In this case 0.0 will 
be evaluated as false and all other values will evaluate to true.

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
                "total_sales": {
                    "sum": {
                        "field": "price"
                    }
                },
                "sales_bucket_filter": {
                    "bucket_selector": {
                        "buckets_path": {
                          "totalSales": "total_sales"
                        },
                        "script": "totalSales <= 50"
                    }
                }
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
    new SumAggregation('total_sales', 'price');
);
$scriptAggregation = new BucketSelectorAggregation(
    'sales_bucket_filter',
    ['totalSales' => 'total_sales']
);
$scriptAggregation->setScript('totalSales <= 50');
$dateAggregation->addAggregation($scriptAggregation);

$search->addAggregation($dateAggregation);

$aggArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-bucket-selector-aggregation.html