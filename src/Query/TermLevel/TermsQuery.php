<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Query\TermLevel;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "terms" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-terms-query.html
 */
class TermsQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(
        private string $field,
        private mixed $terms,
        array $parameters = []
    ) {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'terms';
    }

    public function toArray(): array
    {
        $query = [
            $this->field => $this->terms,
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }
}
