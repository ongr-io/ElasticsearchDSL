# Fuzzy Like This Query

> More info about fuzzy like this field query is in the [official elasticsearch docs][1]

Fuzzy like this query find documents that are "like" provided text by running it against one or more fields.

## Simple example

```JSON
{
    "fuzzy_like_this" : {
        "fields" : ["name.first", "name.last"],
        "like_text" : "text like this one",
        "max_query_terms" : 12
    }
}
```

In DSL:

```php
$fuzzyLikeThisQuery = new FuzzyLikeThisQuery(
    ['name.first', 'name.last'],
    'text like this one',
    [ 'max_query_terms' => 12 ]
);

$search = new Search();
$search->addQuery($fuzzyLikeThisQuery);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-flt-query.html
