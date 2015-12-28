# ElasticsearchDSL

[![Join the chat at https://gitter.im/ongr-io/support](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/ongr-io/support?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Latest Stable Version](https://poser.pugx.org/ongr/elasticsearch-dsl/v/stable)](https://packagist.org/packages/ongr/elasticsearch-dsl)
[![Latest Unstable Version](https://poser.pugx.org/ongr/elasticsearch-dsl/v/unstable)](https://packagist.org/packages/ongr/elasticsearch-dsl)
[![License](https://poser.pugx.org/ongr/elasticsearch-dsl/license)](https://packagist.org/packages/ongr/elasticsearch-dsl)
[![Build Status](https://travis-ci.org/ongr-io/ElasticsearchDSL.svg?branch=master)](https://travis-ci.org/ongr-io/ElasticsearchDSL)

Introducing Elasticsearch DSL library to provide objective query builder for [Elasticsearch bundle](https://github.com/ongr-io/ElasticsearchBundle) and [elasticsearch-php](https://github.com/elastic/elasticsearch-php) client. You can easily build any Elasticsearch query and transform it to an array.

If you have any questions, don't hesitate to ask them on [![Join the chat at https://gitter.im/ongr-io/support](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/ongr-io/support) chat, or just come to say Hi ;).

## Documentation

[The online documentation of the bundle is here](docs/index.md)

## Try it!

### Installation

Install library with [composer](https://getcomposer.org):

```
composer require ongr/elasticsearch-dsl "~1.0"
```

### Search

Elasticsearch DSL was extracted from [Elasticsearch Bundle](https://github.com/ongr-io/ElasticsearchBundle) to provide standalone query dsl for [elasticsearch-php](https://github.com/elastic/elasticsearch-php). Examples how to use it together with [Elasticsearch Bundle](https://github.com/ongr-io/ElasticsearchBundle) can be found in the [Elasticsearch Bundle docs](https://github.com/ongr-io/ElasticsearchBundle/blob/master/Resources/doc/search.md).

If you dont want to use Symfony or Elasticsearch bundle, no worries, you can use it in any project together with [elasticsearch-php](https://github.com/elastic/elasticsearch-php). Here's the example:

Install `elasticsearch-php`:

```
composer require "elasticsearch/elasticsearch": "~2.0"
```

Create search:

```php
 <?php
  require 'vendor/autoload.php';
  $client = ClientBuilder::create()->build();
  
  $matchAll = new ONGR\ElasticsearchDSL\Query\MatchAllQuery();
  
  $search = new ONGR\ElasticsearchDSL\Search();
  $search->addQuery($matchAll)
  
  $params = [
    'index' => 'your_index',
    'body' => $search->toArray(),
  ];
  
  $results = $client->search($params);
```

Elasticsearch DSL covers every elasticsearch query, all examples can be found in [the documentation](docs/index.md)
