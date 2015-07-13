# Fuzzy Like This Field Query

> More info about fuzzy like this field query is in the [official elasticsearch docs][1]

The fuzzy like this field query is the same as the [fuzzy like this query][2], except that it runs against a single
field. It provides nicer query DSL over the generic fuzzy like this query, and support typed fields query
(automatically wraps typed fields with type filter to match only on the specific type).

## Simple example

```JSON
{
    "fuzzy_like_this_field" : {
        "name.first" : {
            "like_text" : "text like this one",
            "max_query_terms" : 12
        }
    }
}
```

In DSL:

```php
$fuzzyLikeThisFieldQuery = new FuzzyLikeThisFieldQuery(
    'name.first',
    'text like this one',
    [ 'max_query_terms' => 12 ]
);

$search = new Search();
$search->addQuery($fuzzyLikeThisFieldQuery);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-flt-field-query.html
[2]: FuzzyLikeThisQuery.md
