# Geo Shape Filter

> More info about geo shape filter is in the [official elasticsearch docs][1]

Filter documents indexed using the geo shape type.

## Simple example

```JSON
{
    "query":{
        "filtered": {
            "query": {
                "match_all": {}
            },
            "filter": {
                "geo_shape": {
                    "location": {
                        "shape": {
                            "type": "envelope",
                            "coordinates" : [[13.0, 53.0], [14.0, 52.0]]
                        }
                    }
                }
            }
        }
    }
}
```

And now the query via DSL:

```php
$geoShapeFilter = new GeoShapeFilter();
$geoShapeFilter->addShape('location', 'envelope', [[13.0, 53.0], [14.0, 52.0]]);

$search = new Search();
$search->addFilter($geoShapeFilter);

$queryArray = $search->toArray();
```

## Pre Indexed Shape

```JSON
{
    "filtered": {
        "query": {
            "match_all": {}
        },
        "filter": {
            "geo_shape": {
                "location": {
                    "indexed_shape": {
                        "id": "DEU",
                        "type": "countries",
                        "index": "shapes",
                        "path": "location"
                    }
                }
            }
        }
    }
}
```

And now the query via DSL:

```php
$geoShapeFilter = new GeoShapeFilter();
$geoShapeFilter->addPreIndexedShape(
    'location',
    'DEU',
    'countries',
    'shapes',
    'location'
);

$search = new Search();
$search->addFilter($geoShapeFilter);

$queryArray = $search->toArray();
```


[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-shape-filter.html
