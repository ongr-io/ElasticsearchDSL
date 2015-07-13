# Query

Objective filter builder represents all available [Elasticsearch filters][1].

To form a filtered query you have to create `Search` object. See below an example of match all filter usage.

```php
$search = new Search();
$matchAllFilter = new MatchAllFilter();
$search->addFilter($matchAllFilter);
$queryArray = $search->toArray();
```

Filters handles are necessary little things like where to put `\stdClass` and where to simple array. So by using DSL builder you can be always sure that it will form a correct query.

Here's `$queryArray` var_dump:

```php
//$queryArray content
'query' => [
        'filtered' => [
            'filter' => [
                'match_all' => \stdClass(),
            ]
        ]
    ]
```

For more information how to combine search queries take a look at [How to search](../HowTo/HowToSearch.md) chapter.


## Filters:
 - [And](And.md)
 - [Bool](Bool.md)
 - [Exists](Exists.md)
 - [GeoBoundingBox](GeoBoundingBox.md)
 - [GeoDistance](GeoDistance.md)
 - [GeoDistanceRange](GeoDistanceRange.md)
 - [GeoPolygon](GeoPolygon.md)
 - [GeoShape](GeoShape.md)
 - [GeohashCell](GeohashCell.md)
 - [HasChild](HasChild.md)
 - [HasParent](HasParent.md)
 - [Ids](Ids.md)
 - [Indices](Indices.md)
 - [Limit](Limit.md)
 - [MatchAll](MatchAll.md)
 - [Missing](Missing.md)
 - [Nested](Nested.md)
 - [Not](Not.md)
 - [Or](Or.md)
 - [Post](Post.md)
 - [Prefix](Prefix.md)
 - [Query](Query.md)
 - [Range](Range.md)
 - [Regexp](Regexp.md)
 - [Script](Script.md)
 - [Term](Term.md)
 - [Terms](Terms.md)
 - [Type](Type.md)


[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-filters.html
