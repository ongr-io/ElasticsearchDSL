# Match Phrase Prefix Query

> More info about match phrase prefix query is in the [official elasticsearch docs][1]

The `match_phrase_prefix` is the same as `match_phrase`, except that it allows for prefix matches on the last term in the text. For example

## Simple example

```JSON
{
    "query": {
        "match_phrase_prefix" : {
            "message" : {
                "query" : "quick brown f",
                "max_expansions" : 10
            }
        }
    }
}
```

In DSL:

```php
$query = new MatchPhrasePrefixQuery('message', 'quick brown f');
$query->addParameter('max_expansions', 10);

$search = new Search();
$search->addQuery($query);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query-phrase-prefix.html
