# Regexp Filter

> More info about regexp filter is in the [official elasticsearch docs][1]

The regexp filter allows you to use regular expression term queries.
The regexp filter is similar to the [regexp query][2],
except that it is cacheable and can speedup performance in case you are
reusing this filter in your queries.

## Simple example

```JSON
{
    "regexp":{
        "name.first": "s.*y"
    }
}
```

And now the query via DSL:

```php
$regexpFilter = new RegexpFilter('name.first', 's.*y');

$search = new Search();
$search->addFilter($regexpFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-indices-filter.html
[2]: ../Query/Regexp.md