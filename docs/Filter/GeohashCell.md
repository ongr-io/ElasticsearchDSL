# Geohash Cell Filter

> More info about geohash cell filter is in the [official elasticsearch docs][1]

The geohash cell filter provides access to a hierarchy of geohashes.
By defining a geohash cell, only geopoints within this cell will match this filter.

## Simple example

```JSON
{
    "filtered" : {
        "query" : {
            "match_all" : {}
        },
        "filter" : {
            "geohash_cell": {
                "pin": {
                    "lat": 13.4080,
                    "lon": 52.5186
                },
                "precision": 3,
                "neighbors": true
            }
        }
    }
}
```

And now the query via DSL:

```php
$geohashCellFilter = new GeohashCellFilter(
    'pin',
    [
        'lat' => 13.4080,
        'lon' => 52.5186,
    ],
    [
        'precision' => 3,
        'neighbors' => true,
    ]
);

$search = new Search();
$search->addFilter($geohashCellFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geohash-cell-filter.html
