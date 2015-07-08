# Nested Filter

> More info about nested filter is in the [official elasticsearch docs][1]

Nested filter allows to filter nested objects / documents (see nested mapping).
The filter is executed against the nested objects / documents as if they
were indexed as separate documents (they are, internally) and resulting
in the root parent doc (or parent nested mapping).

## Simple example

```JSON
{
    "filtered" : {
        "query" : { "match_all" : {} },
        "filter" : {
            "nested" : {
                "path" : "obj1",
                "filter" : {
                    "bool" : {
                        "must" : [
                            {
                                "term" : {"obj1.name" : "blue"}
                            },
                            {
                                "range" : {"obj1.count" : {"gt" : 5}}
                            }
                        ]
                    }
                },
                "_cache" : true
            }
        }
    }
}
```

And now the query via DSL:

```php
$termFilter = new TermFilter('obj1.name', 'blue');
$rangeFilter = new RangeFilter('obj1.count', ['gt' => 5]);

$boolFilter = new BoolFilter();
$boolFilter->add($termFilter);
$boolFilter->add($rangeFilter);

$nestedFilter = new NestedFilter('obj1', $boolFilter, ['_cache' => true]);

$search = new Search();
$search->addFilter($nestedFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-nested-filter.html
