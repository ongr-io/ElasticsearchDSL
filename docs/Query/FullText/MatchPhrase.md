# MatchPhrase Query

> More info about match phrase query is in the [official elasticsearch docs][1]

The match_phrase query analyzes the text and creates a phrase query out of the analyzed text. For example:

## Simple example

```JSON
{
    "query": {
        "match_phrase" : {
            "message" : {
                "query" : "this is a test",
                "analyzer" : "my_analyzer"
            }
        }
    }
}
```

In DSL:

```php
$query = new MatchPhraseQuery('message', 'this is a test');
$query->addParameter('analyzer', 'my_analyzer');

$search = new Search();
$search->addQuery($query);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query-phrase.html
