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

namespace ONGR\ElasticsearchDSL\Query\Compound;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "function_score" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-function-score-query.html
 */
class FunctionScoreQuery implements BuilderInterface
{
    use ParametersTrait;

    private array $functions;

    public function __construct(private ?BuilderInterface $query = null, array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    public function getQuery(): ?BuilderInterface
    {
        return $this->query;
    }

    public function addFieldValueFactorFunction(
        string $field,
        float $factor,
        string $modifier = 'none',
        BuilderInterface $query = null,
        mixed $missing = null
    ): static {
        $function = [
            'field_value_factor' => array_filter(
                [
                    'field' => $field,
                    'factor' => $factor,
                    'modifier' => $modifier,
                    'missing' => $missing
                ]
            ),
        ];

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    private function applyFilter(array &$function, BuilderInterface $query = null): void
    {
        if ($query) {
            $function['filter'] = $query->toArray();
        }
    }

    public function addDecayFunction(
        string $type,
        string $field,
        array $function,
        array $options = [],
        BuilderInterface $query = null,
        int $weight = null
    ): static {
        $function = array_filter(
            [
                $type => array_merge(
                    [$field => $function],
                    $options
                ),
                'weight' => $weight,
            ]
        );

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    public function addWeightFunction(float $weight, BuilderInterface $query = null): static
    {
        $function = [
            'weight' => $weight,
        ];

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    public function addRandomFunction(mixed $seed = null, BuilderInterface $query = null): static
    {
        $function = [
            'random_score' => $seed ? ['seed' => $seed] : new \stdClass(),
        ];

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    public function addScriptScoreFunction(
        string $inline,
        array $params = [],
        array $options = [],
        BuilderInterface $query = null
    ): static {
        $function = [
            'script_score' => [
                'script' =>
                    array_filter(
                        array_merge(
                            [
                                'lang' => 'painless',
                                'inline' => $inline,
                                'params' => $params
                            ],
                            $options
                        )
                    )
            ],
        ];

        $this->applyFilter($function, $query);
        $this->functions[] = $function;

        return $this;
    }

    public function addSimpleFunction(array $function): static
    {
        $this->functions[] = $function;

        return $this;
    }

    public function toArray(): array
    {
        $query = [
            'query' => $this->query->toArray() ?: null,
            'functions' => $this->functions,
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

    public function getType(): string
    {
        return 'function_score';
    }
}
