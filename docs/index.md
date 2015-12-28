# Elasticsearch DSL

Welcome to Elasticsearch DSL library. The main purpose of this library is to provide objective query builder for [elasticsearch-php][1] client.

Everything starts from the `Search` object. We recommend first to take a look at the [Search](HowTo/HowToSearch.md) chapter.

### Topics:
- [Build Queries](Query/index.md)
- [Build Filters](Filter/index.md)
- [Build Aggregations](Aggregation/index.md)

> WARNING: Filters are deprecated since 1.1 and will be removed in 2.0. Elasticsearch from 2.0 casts queries the same way as filters, so there is no reason to have both. More information in [the elasticsearch docs](https://www.elastic.co/guide/en/elasticsearch/reference/2.0/query-dsl-filters.html)

### How to
- [How to Search](HowTo/HowToSearch.md)
- [How to set custom parameters to Search](HowTo/CustomParameters.md)
- more coming soon..

[1]: https://github.com/elastic/elasticsearch-php
