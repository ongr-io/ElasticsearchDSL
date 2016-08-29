# Bucket Script Aggregation

> More info bucket script aggregation is in the [official elasticsearch docs][1]

A parent pipeline aggregation which executes a script which can perform per bucket 
computations on specified metrics in the parent multi-bucket aggregation. The specified 
metric must be numeric and the script must return a numeric value.

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
                "t-shirts": {
                  "filter": {
                    "term": {
                      "type": "t-shirt"
                    }
                  },
                  "aggs": {
                    "sales": {
                      "sum": {
                        "field": "price"
                      }
                    }
                  }
                },
                "t-shirt-percentage": {
                    "bucket_script": {
                        "buckets_path": {
                          "tShirtSales": "t-shirts>sales",
                          "totalSales": "total_sales"
                        },
                        "script": "tShirtSales / totalSales * 100"
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
$sumAggregation = new SumAggregation('total_sales', 'price');
$filterAggregation = new FilterAggregation(
    't-shirts',
    new TermQuery('type', 't-shirt')
);
$filterAggregation->addAggregation(
    new SumAggregation('ales', 'price')
);
$dateAggregation->addAggregation(
    
);
$scriptAggregation = new BucketScriptAggregation(
    't-shirt-percentage',
    [
        'tShirtSales' => 't-shirts>sales',
        'totalSales'  => 'total_sales',
    ]
);
$scriptAggregation->setScript('tShirtSales / totalSales * 100');
$dateAggregation->addAggregation($sumAggregation);
$dateAggregation->addAggregation($filterAggregation);
$dateAggregation->addAggregation($scriptAggregation);

$search->addAggregation($dateAggregation);

$aggArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-bucket-script-aggregation.html