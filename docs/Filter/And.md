# And Filter

> More info about and filter is in the [official elasticsearch docs][1]

A filter that matches documents using the AND boolean operator on other filters.
Can be placed within queries that accept a filter.

## Simple example

```JSON
{
    "filtered" : {
        "query" : {
            "term" : { "name.first" : "shay" }
        },
        "filter" : {
            "and" : [
                {
                    "range" : {
                        "postDate" : {
                            "from" : "2010-03-01",
                            "to" : "2010-04-01"
                        }
                    }
                },
                {
                    "prefix" : { "name.second" : "ba" }
                }
            ]
        }
    }
}
```

And now the query via DSL:

```php
$rangeFilter = new RangeFilter('postDate', ['from' => '2010-03-01', 'to' => '2010-04-01']);
$prefixFilter = new PrefixFilter('name.second', 'ba');
$andFilter = new AndFilter([$rangeFilter, $prefixFilter]);

$termQuery = new TermQuery('name.first', 'shay');

$search = new Search();
$search->addQuery($termQuery);
$search->addFilter($andFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-and-filter.html
