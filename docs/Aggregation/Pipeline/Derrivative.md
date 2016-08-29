# Derivative Aggregation

> More info about derivative aggregation is in the [official elasticsearch docs][1]

A parent pipeline aggregation which calculates the derivative of a specified metric in a parent 
histogram (or date_histogram) aggregation. The specified metric must be numeric and the enclosing 
histogram must have min_doc_count set to 0 (default for histogram aggregations).

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
                "sales_deriv": {
                    "derivative": {
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
$dateAggregation = new DateHistogramAggregation('sales_per_month', 'date', 'month');
$sumAggregation = new SumAggregation('sales', 'price');
$derivativeAggregation = new DerivativeAggregation('sales_deriv', 'sales');
$dateAggregation->addAggregation($sumAggregation);
$dateAggregation->addAggregation($derivativeAggregation);

$search = new Search();
$search->addAggregation($dateAggregation);

$queryArray = $search->toArray();
```

## Second order derivative

Somewhat more complex would be an example of a second order derivatives. This functionality
is presented in the folowing example:

```json
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
                "sales_deriv": {
                    "derivative": {
                        "buckets_path": "sales"
                    }
                },
                "sales_2nd_deriv": {
                    "derivative": {
                        "buckets_path": "sales_deriv" 
                    }
                }
            }
        }
    }
}
```

And now via DSL:

```php
$dateAggregation = new DateHistogramAggregation('sales_per_month', 'date', 'month');
$sumAggregation = new SumAggregation('sales', 'price');
$firstDerivativeAggregation = new DerivativeAggregation('sales_deriv', 'sales');
$secondDerivativeAggregation = new DerivativeAggregation('sales_2nd_deriv', 'sales_deriv');

$dateAggregation->addAggregation($sumAggregation);
$dateAggregation->addAggregation($firstDerivativeAggregation);
$dateAggregation->addAggregation($secondDerivativeAggregation);

$search = new Search();
$search->addAggregation($dateAggregation);

$queryArray = $search->toArray();

```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-derivative-aggregation.html
