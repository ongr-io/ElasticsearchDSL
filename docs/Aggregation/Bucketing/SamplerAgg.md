# Sampler Aggregation

> More info about histogram aggregation is in the [official elasticsearch docs][1]

A filtering aggregation used to limit any sub aggregations' processing to a sample of the top-scoring documents. Optionally,
diversity settings can be used to limit the number of matches that share a common value such as an "author".

## Simple example

```JSON
{
    "aggregations": {
        "sample": {
            "sampler": {
                "shard_size": 200,
                "field" : "user.id"
            },
            "aggs": {
                 "keywords": {
                     "significant_terms": {
                         "field": "text"
                     }
                 }
            }
        }
    }
}
```

And now the query via DSL:

```php
$samplerAggregation = new SamplerAggregation('sample', 'user.id', 200);
$samplerAggregation->addAggregation(
    new SignificantTermsAggregation('keywords', 'text')
);

$search = new Search();
$search->addAggregation($samplerAggregation);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-sampler-aggregation.html
