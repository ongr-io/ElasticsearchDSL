# Nested Inner Hits

> More info about inner hits is in the [official elasticsearch docs][1]

The nested inner_hits can be used to include nested inner objects as inner hits to a search hit.
The actual matches in the different scopes that caused a document to be returned is hidden.
In many cases, it’s very useful to know which inner nested objects caused certain information to be returned.

## Simple example

```JSON
{
    "query" : {
        "nested" : {
            "path" : "comments",
            "query" : {
                "match" : {"comments.message" : "[actual query]"}
            }
        }
    },
    "inner_hits" : {
        "comment" : {
            "path" : {
                "comments" : {
                    "query" : {
                        "match" : {"comments.message" : "[different query]"}
                    }
                }
            }
        }
    }
}
```

And now the query via DSL:

```php
$matchQuery = new MatchQuery('comments.message', '[different query]');
$nestedQuery = new NestedQuery('comments', $matchQuery);
$searchQuery = new Search();
$searchQuery->add($matchQuery);
$innerHit = new NestedInnerHit('comment', 'comments', $searchQuery);

$search = new Search();
$search->addQuery(new MatchQuery('comments.message', '[actual query]'));
$search->addInnerHit($innerHit);
$search->toArray();
```

In the example above `comment` is the name of the inner hit, `comments` is the path
to the nested field and `$matchQuery` is the actual query that will be executed.

## Nesting inner hits

It is possible to nest inner hits in order to reach deeper levels of nested objects.
Here is an example of nesting inner hits:

```JSON
{
  "inner_hits": {
    "cars": {
      "path": {
        "cars": {
          "query": {
            "nested": {
              "path": "cars.manufacturers",
              "query": {
                "match": {
                  "cars.manufacturers.country": {
                    "query": "Japan"
                  }
                }
              }
            }
          },
          "inner_hits": {
            "manufacturers": {
              "path": {
                "cars.manufacturers": {
                  "query": {
                    "match": {
                      "cars.manufacturers.country": {
                        "query": "Japan"
                      }
                    }
                  }
                }
              }
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

$matchQuery = new MatchQuery('cars.manufacturers.country', 'Japan');
$matchSearch = new Search();
$matchSearch->addQuery($matchQuery);

$nestedQuery = new NestedQuery('cars.manufacturers', $matchQuery);
$nestedSearch = new Search();
$nestedSearch->addQuery($nestedQuery);

$innerHitNested = new NestedInnerHit('manufacturers', 'cars.manufacturers', $matchSearch);

$innerHit = new NestedInnerHit('cars', 'cars', $nestedSearch);
$nestedSearch->addInnerHit($innerHitNested);

$search = new Search();
$search->addInnerHit($innerHit);
$search->toArray();

```
[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-inner-hits.html
