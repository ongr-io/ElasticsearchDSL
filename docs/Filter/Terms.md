# Terms Filter

> More info about terms filter is in the [official elasticsearch docs][1]

Filters documents that have fields that match any of the provided terms.

## Simple example

```JSON
{
    "filter" : {
       "terms" : { "user" : ["kimchy", "elasticsearch"]}
    }
}
```

And now the query via DSL:

```php
$termsFilter = new TermsFilter('user', ['kimchy', 'elasticsearch']);

$search = new Search();
$search->addFilter($termsFilter);

$queryArray = $search->toArray();
```

[1]: https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-terms-filter.html
