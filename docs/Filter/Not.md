# Not Filter

> More info about not filter is in the [official elasticsearch docs][1]

A filter that filters out matched documents using a query.

## Simple example

```JSON
{
    "filtered" : {
        "query" : {
            "term" : { "name.first" : "shay" }
        },
        "filter" : {
            "not" : {
                "range" : {
                    "postDate" : {
                        "from" : "2010-03-01",
                        "to" : "2010-04-01"
                    }
                }
            }
        }
    }
}
```

And now the query via DSL:

```php
$rangeFilter = new RangeFilter(
    'postDate',
    [
        'from' => '2010-03-01',
        'to' => '2010-04-01',
    ]
);

$notFilter = new NotFilter($rangeFilter);

$termQuery = new TermQuery('name.first', 'shay');
$filteredQuery = new FilteredQuery($termQuery, $notFilter);

$search = new Search();
$search->addQuery($filteredQuery);
$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-not-filter.html
