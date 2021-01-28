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
 * Represents Elasticsearch "bool" query.
 *
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-query.html
 */
class BoolQuery implements BuilderInterface
{
    use ParametersTrait;

    public const MUST = 'must';

    public const MUST_NOT = 'must_not';

    public const SHOULD = 'should';

    public const FILTER = 'filter';

    private array $container = [];

    public function __construct(array $container = [])
    {
        foreach ($container as $type => $queries) {
            $queries = is_array($queries) ? $queries : [$queries];

            array_walk(
                $queries,
                function (BuilderInterface $query) use ($type): void {
                    $this->add($query, $type);
                }
            );
        }
    }

    public function getQueries(?string $boolType = null): array
    {
        if ($boolType === null) {
            $queries = [];

            foreach ($this->container as $item) {
                $queries = array_merge($queries, $item);
            }

            return $queries;
        }

        if (isset($this->container[$boolType])) {
            return $this->container[$boolType];
        }

        return [];
    }

    public function add(BuilderInterface $query, string $type = self::MUST, ?string $key = null): string
    {
        if (!in_array($type, [self::MUST, self::MUST_NOT, self::SHOULD, self::FILTER])) {
            throw new \UnexpectedValueException(sprintf('The bool operator %s is not supported', $type));
        }

        if (!$key) {
            $key = bin2hex(random_bytes(30));
        }

        $this->container[$type][$key] = $query;

        return $key;
    }

    public function toArray(): array
    {
        if (count($this->container) === 1 && isset($this->container[self::MUST])
            && count($this->container[self::MUST]) === 1) {
            $query = reset($this->container[self::MUST]);

            return $query->toArray();
        }

        $output = [];

        foreach ($this->container as $boolType => $builders) {
            /** @var BuilderInterface $builder */
            foreach ($builders as $builder) {
                $output[$boolType][] = $builder->toArray();
            }
        }

        $output = $this->processArray($output);

        if (empty($output)) {
            $output = new \stdClass();
        }

        return [$this->getType() => $output];
    }

    public function getType(): string
    {
        return 'bool';
    }
}
