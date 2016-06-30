# Raw Aggregation

A multi-bucket raw aggregaton, where you can define your own custom aggregation without any predefined format.
The use case for this aggregation is to be able to use aggregations that are new to Elasticsearch and not
implemented in the ElasticsearchDSL yet. A usage example can be found bellow:

## Simple example

```JSON
{
    "aggregations" : {
        "terms" : {
            "raw" : {
                "field" : "name"
            }
            "aggregations" : {
                "sum_aggregation" : {
                    "sum" : {
                        "field" : "change"
                    }
                }
            }
        }
    }
}
```

And now the query via DSL:

```php
$nestedAggregation = new SumAggregation('sum_aggregation', 'change');

$aggregaton_body = [
    'field' => 'name',
    'aggregations' => [$nestedAggregation]
];
$rawAggregation = new RawAggregation('raw', 'terms', $aggregaton_body);

$search = new Search();
$search->addAggregation($termsAggregation);

$queryArray = $search->toArray();
```
