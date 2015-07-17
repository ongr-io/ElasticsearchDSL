# Suggesters

Objective aggregation builder represents all available [Elasticsearch suggestions][1].

To form an suggestion you have to create `Search` object. See below an example of term suggester usage.
([More examples][Suggester.md])

```php
$search = new Search();
$termSuggester = new Suggester(Suggester::TYPE_TERM, 'body', 'the amsterdma meetpu');
$termSuggester->setName('my-suggestion');
$search->addSuggestion($termSuggester);
$queryArray = $search->toArray();
```
Resulting `$queryArray` contents
```php
[
    'suggest' => [
        'my-suggestion' => [
            'text' => 'the amsterdma meetpu',
            'term' => [
                'field' => 'body'
            ],
        ],
    ],
]
```

Suggestion name (*my-suggestion* in example) is optional and will be generated in format `{field}-{type}`

## Suggester Types

There are 4 suggester types:

 - [Term][2]
 - [Phrase][3]
 - [Completion][4]
 - [Context][5]

In DSL all types are represented with a single class and type is set with the help of one of these constants:

 - TYPE_TERM
 - TYPE_PHRASE
 - TYPE_COMPLETION
 - TYPE_CONTEXT

All 4 are used in a similar way, only difference is parameters (which can be found in Elasticsearch documentation) and
`context` suggester also accepts [contexts][context.md]

## Payloads

Do not forget to add payloads to your documents suggestions for completions to be useful.

> Payload - an arbitrary JSON object, which is simply returned in the suggest option. You could store data like
  the id of a document, in order to load it from elasticsearch without executing another search
  (which might not yield any results, if input and output differ strongly).

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-suggesters.html
[2]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-suggesters-term.html
[3]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-suggesters-phrase.html
[4]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-suggesters-completion.html
[5]: https://www.elastic.co/guide/en/elasticsearch/reference/current/suggester-context.html
