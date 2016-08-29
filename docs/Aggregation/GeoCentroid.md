# Geo Centroid Aggregation

> More info about histogram aggregation is in the [official elasticsearch docs][1]

A metric aggregation that computes the weighted centroid from all coordinate values for a Geo-point datatype field.
The data type of the field that is specified for the aggregation must be `geo-point`.

## Simple example

```JSON
{
    "query" : {
        "match" : { "crime" : "burglary" }
    },
    "aggs" : {
        "centroid" : {
            "geo_centroid" : {
                "field" : "location"
            }
        }
    }
}
```

And now the query via DSL:

```php
$geoCentroidAggregation = new GeoCentroidAggregation('centroid', 'location');

$search = new Search();
$search->addQuery(new MatchQuery('crime', 'burglary'));
$search->addAggregation($geoCentroidAggregation);

$queryArray = $search->toArray();
```

## Advanced example

The query provides more information when when combined as a sub-aggregation to other bucket aggregations. Here is an example of that:

```JSON

{
    "query" : {
        "match" : { "crime" : "burglary" }
    },
    "aggs" : {
        "towns" : {
            "terms" : { "field" : "town" },
            "aggs" : {
                "centroid" : {
                    "geo_centroid" : { "field" : "location" }
                }
            }
        }
    }
}

```
And now via DSL:

```php
$geoCentroidAggregation = new GeoCentroidAggregation('centroid', 'location');
$termsAggregation = new TermsAggregation('towns', 'town');
$termsAggregation->addAggregation($geoCentroidAggregation);

$search = new Search();
$search->addQuery(new MatchQuery('crime', 'burglary'));
$search->addAggregation($termsAggregation);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-geocentroid-aggregation.html
