# Parent Inner Hits

> More info about inner hits is in the [official elasticsearch docs][1]

The `parent/child` inner_hits can be used to include parent or child. 
The usage of parent inner hits is very similar to that of nested [inner hits](Nested.md), the only
difference is that in stead of passing the `path` to the nested object, the parent/child `type` 
needs to be passed to the `$path` variable. 

## Simple example

```JSON
{
    "inner_hits" : {
        "children" : {
            "type" : {
                "article" : {
                    "query" : {
                        "match" : {"title" : "[actual query]"}
                    }
                }
            }
        }
    }
}
```

And now the query via DSL:

```php
$matchQuery = new MatchQuery('title', '[actual query]');
$innerHit = new ParentInnerHit('children', 'article', $matchQuery);

$search = new Search();
$search->addInnerHit($innerHit);
$search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-request-inner-hits.html
