# Significant Terms Aggregation

> More info about histogram aggregation is in the [official elasticsearch docs][1]

An aggregation that returns interesting or unusual occurrences of terms in a set.

## Simple example

```JSON
{
    "query" : {
        "terms" : {"force" : [ "British Transport Police" ]}
    },
    "aggregations" : {
        "significantCrimeTypes" : {
            "significant_terms" : { "field" : "crime_type" }
        }
    }
}
```

And now the query via DSL:

```php
$significantTermsAggregation = new SignificantTermsAggregation('significantCrimeTypes', 'crime_type');
$query = new TermsQuery('force', ['British Transport Police']);

$search = new Search();
$search->addQuery($query);
$search->addAggregation($histogramAggregation);

$queryArray = $search->toArray();
```

## Multi-set Analysis

A simpler way to perform analysis across multiple categories is to use a parent-level aggregation to segment the data ready for analysis.

```JSON

{
    "aggregations": {
        "forces": {
            "terms": {"field": "force"},
            "aggregations": {
                "significantCrimeTypes": {
                    "significant_terms": {"field": "crime_type"}
                }
            }
        }
    }
}

```

And now the query via DSL:

```php

$significantTermsAggregation = new SignificantTermsAggregation('significantCrimeTypes', 'crime_type');
$termsAggregation = new TermsAggregation('forces', 'force');
$termsAggregation->addAggregation($significantTermsAggregation);

$search = new Search();
$search->addAggregation($termsAggregation);

$queryArray = $search->toArray();

```

Other top level aggregations can be used to segment the data, for example, it can be segmented by
geographic area to identify unusual hot-spots of a particular crime:

```JSON

{
    "aggs": {
        "hotspots": {
            "geohash_grid" : {
                "field":"location",
                "precision":5,
            },
            "aggs": {
                "significantCrimeTypes": {
                    "significant_terms": {"field": "crime_type"}
                }
            }
        }
    }
}

```

And now via DSL:

```php

$significantTermsAggregation = new SignificantTermsAggregation('significantCrimeTypes', 'crime_type');
$geoHashAggregation = new GeoHashGridAggregation('hotspots', 'location', 5);
$geoHashAggregation->addAggregation($significantTermsAggregation);

$search = new Search();
$search->addAggregation($geoHashAggregation);

$queryArray = $search->toArray();

```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-significantterms-aggregation.html
