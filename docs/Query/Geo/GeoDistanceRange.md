# Geo Distance Range Query

> More info about geo distance range query is in the [official elasticsearch docs][1]

> This query was deprecated as of elasticsearch 5.0. Distance aggregations or sorting should be used instead.

Filters documents that exists within a range from a specific point:

## Simple example

```JSON
{
    "query": {
        "bool" : {
            "must" : {
                "match_all" : {}
            },
            "filter" : {
                "geo_distance_range" : {
                    "from" : "200km",
                    "to" : "400km",
                    "pin.location" : {
                        "lat" : 40,
                        "lon" : -70
                    }
                }
            }
        }
    }
}
```

In DSL:

```php
$search = new Search();
$boolQuery = new BoolQuery();
$boolQuery->add(new MatchAllQuery());
$geoQuery = new GeoDistanceQuery(
    'pin.location', 
    ['from' => '200km', 'to' => '400km'], 
    ['lat' => 40, 'lon' => -70]
);
$boolQuery->add($geoQuery, BoolQuery::FILTER);
$search->addQuery($boolQuery);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-distance-range-query.html
