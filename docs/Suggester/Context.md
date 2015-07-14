# Context

There are 2 kinds of context currently available *[Category][1]* and *[Geo Location][2]*.

Both contexts are very similar so only 1 class is used, and types can be set with the help of class constants:
 - TYPE_GEO_LOCATION
 - TYPE_CATEGORY

By default `Category` context is used.

Only differences between contexts are how they are formatted and that `GeoLocation` can accept parameters.

## Category Example

```php
$categoryContext = new Context('category', 'event');
```

## Geo Location Example

```php
$locationContext = new Context(
    'location',
    ['lat' => 1, 'lon' => 1],
    Context::TYPE_GEO_LOCATION
);
```

## Usage with context suggester

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

$queryArray = $search->toArray();
```
Resulting array in json:
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
