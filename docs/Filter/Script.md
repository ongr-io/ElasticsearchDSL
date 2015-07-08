# Script Filter

> More info about script filter is in the [official elasticsearch docs][1]

A filter allowing to define scripts as filters

## Simple example

```JSON
{
    "filter" : {
        "script" : {
            "script" : "doc['num1'].value > 1"
        }
    }
}
```

And now the query via DSL:

```php
$scriptFilter = new ScriptFilter('doc[\'num1\'].value > 1');

$search = new Search();
$search->addFilter($scriptFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-script-filter.html
