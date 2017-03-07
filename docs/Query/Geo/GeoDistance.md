# Geo Distance Query

> More info about geo distance query is in the [official elasticsearch docs][1]

Filters documents that include only hits that exists within a specific distance from a geo point:

## Simple example

```JSON
{
    "query": {
        "bool" : {
            "must" : {
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
}
```

In DSL:

```php
$search = new Search();
$boolQuery = new BoolQuery();
$boolQuery->add(new MatchAllQuery());
$geoQuery = new GeoDistanceQuery('pin.location', '200km', ['lat' => 40, 'lon' => -70]);
$boolQuery->add($geoQuery, BoolQuery::FILTER);
$search->addQuery($boolQuery);

$queryArray = $search->toArray();
```

Here, elasticsearch supports passing location in a variety of different formats, therefore
the query permits that as well, however it is up to the user to ensure the validity of the 
data passed to this parameter. Following is an example of a valid location being passed as 
a string:

```json

{
    "query": {
        "bool" : {
            "must" : {
                "match_all" : {}
            },
            "filter" : {
                "geo_distance" : {
                    "distance" : "12km",
                    "pin.location" : "drm3btev3e86"
                }
            }
        }
    }
}

```

And now via DSL:

```php
$search = new Search();
$boolQuery = new BoolQuery();
$boolQuery->add(new MatchAllQuery());
$geoQuery = new GeoDistanceQuery('pin.location', '200km', 'drm3btev3e86');
$boolQuery->add($geoQuery, BoolQuery::FILTER);
$search->addQuery($boolQuery);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-distance-query.html
