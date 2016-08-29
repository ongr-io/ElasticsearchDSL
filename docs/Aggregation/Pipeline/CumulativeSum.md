# Cumulative Sum Aggregation

> More info about cumulative sum aggregation is in the [official elasticsearch docs][1]

A parent pipeline aggregation which calculates the cumulative sum of a specified metric 
in a parent histogram (or date_histogram) aggregation. The specified metric must be numeric 
and the enclosing histogram must have min_doc_count set to 0 (default for histogram 
aggregations).

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
                },
                "cumulative_sales": {
                    "cumulative_sum": {
                        "buckets_path": "sales" 
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
    new SumAggregation('sales', 'price')
);
$dateAggregation->addAggregation(
    new CumulativeSumAggregation('cumulative_sales', 'sales')
);

$search->addAggregation($dateAggregation);

$aggArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-cumulative-sum-aggregation.html