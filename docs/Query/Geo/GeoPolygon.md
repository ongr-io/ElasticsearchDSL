# Geo Polygon Query

> More info about geo polygon query is in the [official elasticsearch docs][1]

A query allowing to include hits that only fall within a polygon of points. Here is an example:

## Simple example

```JSON
{
    "query": {
        "bool" : {
            "must" : {
                "match_all" : {}
            },
            "filter" : {
                "geo_polygon" : {
                    "person.location" : {
                        "points" : [
                        {"lat" : 40, "lon" : -70},
                        {"lat" : 30, "lon" : -80},
                        {"lat" : 20, "lon" : -90}
                        ]
                    }
                }
            }
        }
    }
}
```

In DSL:

```php
$points = [
    ['lat' => 40, 'lon' => -70],
    ['lat' => 30, 'lon' => -80],
    ['lat' => 20, 'lon' => -90],
];
$search = new Search();
$boolQuery = new BoolQuery();
$boolQuery->add(new MatchAllQuery());
$geoQuery = new GeoPolygonQuery('person.location', $points);
$boolQuery->add($geoQuery, BoolQuery::FILTER);
$search->addQuery($boolQuery);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-polygon-query.html
