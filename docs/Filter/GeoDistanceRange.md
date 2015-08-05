# Geo Distance Range Filter

> More info about geo distance range filter is in the [official elasticsearch docs][1]

Filters documents that exists within a range from a specific point.

## Simple example

```JSON
{
    "filtered" : {
        "query" : {
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
```

And now the query via DSL:

```php
$geoDistanceRangeFilter = new GeoDistanceRangeFilter(
    'pin.location',
    ['from' => '200km', 'to' => '400km'],
    ['lat' => 40, 'lon' => -70]
);

$search = new Search();
$search->addFilter($geoDistanceRangeFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-distance-range-filter.html

