# Geo Polygon Filter

> More info about geo polygon range filter is in the [official elasticsearch docs][1]

A filter allowing to include hits that only fall within a polygon of points.

## Simple example

```JSON
{
    "filtered" : {
        "query" : {
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
```

And now the query via DSL:

```php
$geoPolygonFilter = new GeoPolygonFilter(
    'person.location',
    [
        ['lat' => 40, 'lon' => -70],
        ['lat' => 30, 'lon' => -80],
        ['lat' => 20, 'lon' => -90],
    ]
);

$search = new Search();
$search->addFilter($geoPolygonFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-polygon-filter.html
