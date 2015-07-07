# Geo Bounding Box Filter

> More info about geo bounding box filter is in the [official elasticsearch docs][1]

A filter allowing to filter hits based on a point location using a bounding box.

## Simple example

```JSON
{
    "filtered" : {
        "query" : {
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
```

And now the query via DSL:

```php
$geoBoundingBoxFilter = new GeoBoundingBoxFilter(
    'pin.location',
    [
        ['lat' => 40.73, 'lon' => -74.1],
        ['lat' => 40.01, 'lon' => -74.12],
    ]
);

$search = new Search();
$search->addFilter($geoBoundingBoxFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-bounding-box-filter.html
