# Query

Objective query builder represents all available [Elasticsearch queries][1].

To form a query you have to create `Search` object. See below an example of match all query usage.

```php
$search = new Search();
$matchAllQuery = new MatchAllQuery();
$search->addQuery($matchAllQuery);
$queryArray = $search->toArray();
```

Query handles are necessary little things like where to put `\stdClass` and where to simple array. So by using DSL builder you can be always sure that it will form a correct query.

Here's `$queryArray` var_dump:

```php
//$queryArray content
'query' =>
    [
      'match_all' => \stdClass(),
    ]
```

For more information how to combine search queries take a look at [How to search](../HowTo/HowToSearch.md) chapter.

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-queries.html
