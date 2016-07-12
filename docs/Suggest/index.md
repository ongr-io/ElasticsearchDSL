# Suggest

Objective suggest builder in ONGR ElasticsearchDSL represents [Elasticsearch suggesters][1].
The `Suggest` class is universal for all the suggesters that are currently implemented in
Elasticsearch.

The `Suggest` object takes up to 5 parameters during the initiation:

|   Parameter  |                              Description                                   |
|:------------:|:--------------------------------------------------------------------------:|
|    `name`    | The name of the Suggest                                                    |
|    `field`   | The ES field to execute the suggest                                        |
|    `type`    | The type of the suggest (eg. phrase)                                       |
|    `text`    | The text that will be passed to suggest                                    |
| `parameters` | Array of additional parameters that may be unique to every type of suggest |

To form a suggest you have to create `Search` object. See examples below for more information
on suggest usage:

### Simple example

```php
$search = new Search();
$suggest = new Suggest('my_suggest', 'term', 'searchText', 'title', ['size' => 5]);
$search->addSuggest($suggest);
$queryArray = $search->toArray();
```

That will generate following JSON:

```JSON
"suggest": {
  "my_suggest": {
    "text": "searchText",
    "term": {
      "field": "title",
      "size": 5
    }
  }
}
```

### Example of multiple suggests

You're able to create more than one suggest:

```php
$search = new Search();
$suggest1 = new Suggest('my_suggest1', 'term', 'the amsterdma meetpu', 'body', ['size' => 5]);
$search->addSuggest($suggest1);
$suggest2 = new Suggest('my_suggest2', 'term', 'the rottredam meetpu', 'title', ['size' => 5]);
$search->addSuggest($suggest2);
$queryArray = $search->toArray();
```

That will generate following JSON:

```JSON
"suggest": {
  "my_suggest1": {
    "text": "the amsterdma meetpu",
    "term": {
      "field": "body",
      "size": 5
    }
  },
  "my_suggest2": {
    "text": "the rottredam meetpu",
    "term": {
      "field": "title",
      "size": 5
    }
  }
}
```

### Example of phrase suggest

Also, provide different types of suggests, for example, this is a phrase suggest:

```php
$search = new Search();
$suggest = new Suggest(
    'my-suggest',
    'phrase',
    'Xor the Got-Jewel',
    'bigram',
    [
        'analyzer' => 'body',
        'size' => 1,
        'real_word_error_likelihood' => 0.95,
        'max_errors' => 0.5,
        'gram_size' => 2,
        'direct_generator' => [
            [
                'field' => 'body',
                'suggest_mode' => 'always',
                'min_word_length' => 1
            ]
        ],
        'highlight'=> [
            'pre_tag' => '<em>',
            'post_tag' => '</em>'
        ]
    ]
);

$search->addSuggest($suggest);
$queryArray = $search->toArray();

```

That will generate following JSON:

```yaml
"suggest" : {
  "my-suggest"
    "text" : "Xor the Got-Jewel",
    "phrase" : {
      "analyzer" : "body",
      "field" : "bigram",
      "size" : 1,
      "real_word_error_likelihood" : 0.95,
      "max_errors" : 0.5,
      "gram_size" : 2,
      "direct_generator" : [ {
        "field" : "body",
        "suggest_mode" : "always",
        "min_word_length" : 1
      } ],
      "highlight": {
        "pre_tag": "<em>",
        "post_tag": "</em>"
      }
    }
  }
}

```

### Example of completion suggest:

```php

$search = new Search();
$suggest = new Suggest('song-suggest', 'completion', 'n', 'suggest');

$search->addSuggest($suggest);
$queryArray = $search->toArray();

```

That will generate following JSON:

```yaml

"suggest" : {
  "song-suggest" : {
    "text" : "n",
    "completion" : {
      "field" : "suggest"
    }
  }
}

```

### Example of context suggest:

```php

$search = new Search();
$suggest = new Suggest(
    'context-suggestion',
    'completion',
    'm',
    'suggest_field',
    [
        'context' => ['color' => 'red'],
        'size' => 10
    ]
);

$search->addSuggest($suggest);
$queryArray = $search->toArray();

```

That will generate following JSON:

```yaml

"suggest" : {
  "context-suggestion" : {
    "text" : "m",
    "completion" : {
      "field" : "suggest_field",
      "size": 10,
      "context": {
        "color": "red"
      }
    }
  }
}

```

Find out more about suggesters in the official [Elasticsearch suggest documentation][1]

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/search-suggesters.html