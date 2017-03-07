# Geo Bounding Box Query

> More info about geo bounding box query is in the [official elasticsearch docs][1]

A query allowing to filter hits based on a point location using a bounding box. Assuming the following indexed document:

## Simple example

```JSON
{
    "query": {
        "bool" : {
            "must" : {
                "match_all" : {}
            },
            "filter" : {
                "geo_bounding_box" : {
                    "pin.location" : {
                        "top_left" : {
                            "lat" : 40.73,
                            "lon" : -74.1
                        },
                        "bottom_right" : {
                            "lat" : 40.01,
                            "lon" : -71.12
                        }
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
$location = [
    ['lat' => 40.73, 'lon' => -74.1],
    [ 'lat' => 40.01, 'lon' => -71.12],
];
$boolQuery = new BoolQuery();
$boolQuery->add(new MatchAllQuery());
$geoQuery = new GeoBoundingBoxQuery('pin.location', $location);
$boolQuery->add($geoQuery, BoolQuery::FILTER);
$search->addQuery($boolQuery);

$queryArray = $search->toArray();
```

> This query accepts an array with either 2 or 4 elements as its second parameter,
failing to meet this criteria will result in an error!

Alternatively the vertices of the bounding box can be set separately:

```json

{
    "query": {
        "bool" : {
            "must" : {
                "match_all" : {}
            },
            "filter" : {
                "geo_bounding_box" : {
                    "pin.location" : {
                        "top" : 40.73,
                        "left" : -74.1,
                        "bottom" : 40.01,
                        "right" : -71.12
                    }
                }
            }
        }
    }
}

```

Now via DSL:

```php

$search = new Search();
$location = [40.73, -74.1, 40.01, -71.12];
$boolQuery = new BoolQuery();
$boolQuery->add(new MatchAllQuery());
$geoQuery = new GeoBoundingBoxQuery('pin.location', $location);
$boolQuery->add($geoQuery, BoolQuery::FILTER);
$search->addQuery($boolQuery);

$queryArray = $search->toArray();

```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-bounding-box-query.html
