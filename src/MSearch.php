<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace ONGR\ElasticsearchDSL;

use Elasticsearch\Common\Exceptions\InvalidArgumentException;

/**
 * Multi Search object that can be executed by manager
 *
 * Class MSearch
 * @package ONGR\ElasticsearchDSL
 */
class MSearch
{

    /**
     * @var array
     */
    private $queries;

    /**
     * @param Search $search
     * @param null $options
     * @throws \InvalidArgumentException
     *
     * @return Msearch
     */
    public function addSearch(Search $search, $options = null)
    {
        $this->validOptions($options);

        $this->queries[] = [
            'header' => is_null($options) ? [] : $options,
            'body' => $search
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];

        foreach ($this->queries as $query)
        {
            /** @var Search $search */
            $search = $query['body'];
            $result[] = $query['header'];
            $result[] = $search->toArray();
        }

        return $result;
    }

    /**
     * @param $options
     */
    private function validOptions($options)
    {
        if ($options === null) {
            return;
        }

        $validOptions = [
            'index',
            'search_type',
            'preference',
            'routing'
        ];

        foreach ($options as $key => $option) {
            if (!in_array($key, $validOptions)) {
                throw new InvalidArgumentException("Multi search option {$key} is not supported");
            }
        }
    }

}
