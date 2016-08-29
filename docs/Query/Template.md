# Template query

> More info about Boosting query is in the [official elasticsearch docs][1]

A query that accepts a query template and a map of key/value pairs to fill in template parameters.

```JSON
{
    "query": {
        "template": {
            "inline": { "match": { "text": "{{query_string}}" }},
            "params" : {
                "query_string" : "all about search"
            }
        }
    }
}
```

And now the query via DSL:

```php
$template = '"match": { "text": "{{query_string}}"';
$params = ['query_string' => 'all about search'];

$templateQuery = new TemplateQuery();
$templateQuery->setInline($template);
$templateQuery->setParams($params);

$search = new Search();
$search->addQuery($templateQuery);

$queryArray = $search->toArray();
```

The template of the query can also be stored in a different file, that way, the file path must
be provided in stead of `inline` parameter:

```yaml

{
    "query": {
        "template": {
            "file": "my_template",
            "params" : {
                "query_string" : "all about search"
            }
        }
    }
}

```

And now the query via DSL:

```php
$params = ['query_string' => 'all about search'];

$templateQuery = new TemplateQuery();
$templateQuery->setFile('my_template');
$templateQuery->setParams($params);

$search = new Search();
$search->addQuery($templateQuery);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-template-query.html
