# Bool Filter

> More info about filter query is in the [official elasticsearch docs][1]

A filter that matches documents matching boolean combinations of other queries. Similar in concept to
[Boolean query][2], except that the clauses are other filters.

To create a bool filter unlike other queries you don't have to create `BoolFilter` object. Just add queries to the
search object and it will form bool filter automatically.

Lets take an example to write a bool query with Elasticsearch DSL.

```JSON
{
    "filtered" : {
        "query" : {
            "queryString" : {
                "default_field" : "message",
                "query" : "elasticsearch"
            }
        },
        "filter" : {
            "bool" : {
                "must" : {
                    "term" : { "tag" : "wow" }
                },
                "must_not" : {
                    "range" : {
                        "age" : { "gte" : 10, "lt" : 20 }
                    }
                },
                "should" : [
                    {
                        "term" : { "tag" : "sometag" }
                    },
                    {
                        "term" : { "tag" : "sometagtag" }
                    }
                ]
            }
        }
    }
}
```

And now the query via DSL:

```php
$queryStringQuery = new QueryStringQuery('elasticsearch', ['default_field' => 'message']);

$termFilter1 = new TermFilter('tag', 'wow');
$rangeFilter = new RangeFilter('age', ['gte' => 10, 'lt' => 20]);
$termFilter2 = new TermFilter('tag', 'sometag');
$termFilter3 = new TermFilter('tag', 'sometagtag');

$search = new Search();
$search->addQuery($queryStringQuery);
$search->addFilter($termFilter1);
$search->addFilter($rangeFilter, BoolFilter::MUST_NOT);
$search->addFilter($termFilter2, BoolFilter::SHOULD);
$search->addFilter($termFilter3, BoolFilter::SHOULD);

$queryArray = $search->toArray();
```

There is also an exception due adding filters to the search. If you add only one filter without type
it will form simple query. e.g. lets try to create match all filter.

```php
$matchAllFilter = new MatchAllFilter();

$search = new Search();
$search->addFilter($matchAllFilter);

$queryArray = $search->toArray();
```

You will get this query:
```JSON
{
    "query": {
        "filtered": {
            "filter": {
                "match_all": {}
            }
        }
    }
}
```

> More info about `Search` look in the [How to search](../HowTo/HowToSearch.md) chapter.



[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-filter.html
[2]: ../Query/Bool.md