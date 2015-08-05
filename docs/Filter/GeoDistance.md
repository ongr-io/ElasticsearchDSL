# Geo Distance Filter

> More info about geo distance filter is in the [official elasticsearch docs][1]

Filters documents that include only hits that exists within a specific distance from a geo point.

## Simple example

```JSON
{
    "filtered" : {
        "query" : {
            "match_all" : {}
        },
        "filter" : {
            "geo_distance" : {
                "distance" : "200km",
                "pin.location" : {
                    "lat" : 40,
                    "lon" : -70
                }
            }
        }
    }
}
```

And now the query via DSL:

```php
$geoDistanceFilter = new GeoDistanceFilter(
    'pin.location',
    '200km',
    ['lat' => 40, 'lon' => -70]
);

$search = new Search();
$search->addFilter($geoDistanceFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-distance-filter.html
