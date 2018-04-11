# CHANGELOG
v6.0.0 (2017-01-30)
---
- Added support for the Elasticsearch 6

v5.0.0 (2017-01-30)
---
- **Namespace for some queries were changed**. Queries were consolidated to a domain like Elasticsearch does.  All queries were grouped to `Compound`, `FullText`, `Geo`, `Joining`, `Span`, `Specialized` and `TermLevel`.
- PHP version support changed to >=5.6
- Added `elasticsearch\elasticsearch` to required dependency list in the composer.json.
- Deprecated aggregations removed. Check if the namespace is correct. All aggregations grouped to `Bucketing`, `Metric` and `Pipeline` namespaces.
- `Search::getQueryParams()` changed to `Search::getUriParams()`. All setter's for request URI parameters removed in favor of `uriParams` container. You can add URI parameters by `addUriParam`, and this function also has validation.
- `Search::setFields()` and `Search::getFields()` were changed to `Search::setStoredFields()` and `Search::getStoredFields()`.
- `FilterEndpoint` was removed due to deprecated filters in elasticsearch.
- Added missing scroll param to URL params (#202)

v2.2.1 (2017-01-26)
---
- Fixed function score for 2.x elastic.
- Fixed bug in nested and reverse nested aggregations. (#173)
- Fixed bool query key assign for some OS to avoid duplication.

v2.2.0 (2016-11.11)
---
- Added support for elasticsearch 5.0
- Added functional tests to test library on elasticsearch 2.4 and 5.0
   
v2.1.2 (2016-09-22)
---
- Added check if BoolQuery has requested type queries #159
- Added FilterAggregation getter #157
   
v2.1.1 (2016-09-16)
---
- Minor stability fixes
   
v2.1.0 (2016-09-07)
---
- Aggregations were moved to its type namespace to avoid duplications. Old ones deprecated and will be removed in 3.0
- Added all pipeline aggregations
- Added inner hits support
- Added suggest endpoint
- Added new queries like Span Containing, Template and others
   
v2.0.2 (2016-07-11)
---
- Fixed function score query #122
- Added missing options array process in some functions
- Added date histogram aggregation
- Added significant terms aggregation
   
v2.0.1 (2016-05-03)
---
- Fixed FiltersAggregation generates invalid array #91

v1.1.3 (2016-04-17)
---
- Fixed parameters handling in BoolQuery query

v2.0.0 (2016-03-03)
---
- [BC break] Aggregation name is not prefixed anymore
- [BC break] Removed all filters and filtered query
- [BC break] Query's `toArray()` now returns array WITH query type
- [Feature] Added TermSuggest and Suggest endpoint

v1.1.2 (2016-02-01)
---
- Deprecated `FuzzyLikeThisQuery` and `FuzzyLikeThisFieldQuery` queries

v1.1.1 (2016-01-26)
---
- Fixed query endpoint normalization when called repeatedly [#56](https://github.com/ongr-io/ElasticsearchDSL/pull/56)
- Deprecated `DslTypeAwareTrait` and `FilterOrQueryDetectionTrait` traits

v1.1.0 (2015-12-28)
---
- Fixed nested query in case `bool` with single `must` clause given [#32](https://github.com/ongr-io/ElasticsearchDSL/issues/32)
- Deprecated all filters and filtered query [#50](https://github.com/ongr-io/ElasticsearchDSL/issues/50)
- Added `filter` clause support for `BoolQuery` [#48](https://github.com/ongr-io/ElasticsearchDSL/issues/48)

v1.0.1 (2015-12-16)
---
- Fixed `function_score` query options handling [#35](https://github.com/ongr-io/ElasticsearchDSL/issues/35)
- Added Symfony 3 compatibility
- Added support for `timeout` and `terminate_after` options in Search endpoint [#34](https://github.com/ongr-io/ElasticsearchDSL/issues/34)

v1.0.0 (2015-09-14)
---
- First stable version, [more info here](https://github.com/ongr-io/ElasticsearchDSL/blob/v1.0.0/docs/index.md).