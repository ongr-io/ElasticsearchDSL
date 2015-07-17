# Suggester usage examples
## Simple phrase example

```JSON
{
    "suggest": {
        "body-phrase": {
            "text": "the amsterdma meetpu",
            "phrase": {
                "field": "body"
            }
        }
    }
}
```

In DSL:

```php
$termSuggester = new Suggester(Suggester::TYPE_PHRASE, 'body', 'the amsterdma meetpu');

$search = new Search();
$search->addSuggestion($termSuggester);

$queryArray = $search->toArray();
```

## Example with parameters

```JSON
{
    "suggest": {
        "body-term": {
            "text": "the amsterdma meetpu",
            "term": {
                "field": "body"
                "size": 5
                "sort": "score"
            }
        }
    }
}
```

Now in DSL:

```php
$termSuggester = new Suggester(
    Suggester::TYPE_TERM,
    'body',
    'the amsterdma meetpu',
    [
        'size' => 5,
        'sort' => 'score',
    ]
);
$termSuggester->setName('my-suggestion');

$search = new Search();
$search->addSuggestion($termSuggester);

$queryArray = $search->toArray();
```

## [Context][Context.md] example

```JSON
{
    "suggest": {
        "title-completion": {
            "text": "the amsterdma meetpu",
            "completion": {
                "field": "title",
                "context": {
                    "color": "red",
                    "category": "event",
                    "location": {
                        "value": {
                            "lat": 1,
                            "lon": 1
                        },
                        "precision": "1km"
                    }
                }
            }
        }
    }
}
```

```php
$colorContext = new Context('color', 'red');
$categoryContext = new Context('category', 'event');
$locationContext = new Context(
    'location',
    ['lat' => 1, 'lon' => 1],
    Context::TYPE_GEO_LOCATION,
    ['precision' => '1km']
);
$contextSuggester = new Suggester(Suggester::TYPE_CONTEXT, 'title', 'the amsterdma meetpu');
$contextSuggester->addContext($colorContext);
$contextSuggester->addContext($categoryContext);
$contextSuggester->addContext($locationContext);

$search = new Search();
$search->addSuggestion($contextSuggester);
```