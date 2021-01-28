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

namespace ONGR\ElasticsearchDSL\Query\Specialized;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "script" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-script-query.html
 */
class ScriptQuery implements BuilderInterface
{
    use ParametersTrait;

    public function __construct(private string $script, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'script';
    }

    public function toArray(): array
    {
        $query = ['inline' => $this->script];
        $output = $this->processArray($query);

        return [$this->getType() => ['script' => $output]];
    }
}
