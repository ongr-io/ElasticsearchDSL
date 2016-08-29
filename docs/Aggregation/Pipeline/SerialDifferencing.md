# Serial Differencing Aggregation

> More info about serial differencing aggregation is in the [official elasticsearch docs][1]

Serial differencing is a technique where values in a time series are subtracted from itself at 
different time lags or periods

## Simple example

```JSON
{
   "aggs": {
      "my_date_histo": {                  
         "date_histogram": {
            "field": "timestamp",
            "interval": "day"
         },
         "aggs": {
            "the_sum": {
               "sum": {
                  "field": "lemmings"     
               }
            },
            "thirtieth_difference": {
               "serial_diff": {                
                  "buckets_path": "the_sum",
                  "lag" : 30
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

$dateAggregation = new DateHistogramAggregation('my_date_histo', 'timestamp', 'day');
$dateAggregation->addAggregation(
    new SumAggregation('the_sum', 'lemmings')
);
$diffAggregation = new SerialDifferencingAggregation('thirtieth_difference', 'the_sum');
$diffAggregation->addParameter('lag', 30);
$dateAggregation->addAggregation($diffAggregation);

$search->addAggregation($dateAggregation);

$aggArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-serialdiff-aggregation.html