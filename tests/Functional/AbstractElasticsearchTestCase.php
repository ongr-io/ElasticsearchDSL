<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Functional;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use ONGR\ElasticsearchDSL\Search;
use PHPUnit\Framework\TestCase;

abstract class AbstractElasticsearchTestCase extends TestCase
{
    /**
     * Test index name in the elasticsearch.
     */
    const INDEX_NAME = 'elasticsaerch-dsl-test';

    /**
     * @var Client
     */
    private $client;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = ClientBuilder::create()->build();
        $this->deleteIndex();

        $this->client->indices()->create(
            array_filter(
                [
                    'index' => self::INDEX_NAME,
                    'mapping' => $this->getMapping()
                ]
            )
        );

        $bulkBody = [];

        foreach ($this->getDataArray() as $type => $documents) {
            foreach ($documents as $id => $document) {
                $bulkBody[] = [
                   'index' => [
                        '_index' => self::INDEX_NAME,
                        '_type' => $type,
                        '_id' => $id,
                    ]
                ];
                $bulkBody[] = $document;
            }
        }

        $this->client->bulk(
            [
                'body' => $bulkBody
            ]
        );
        $this->client->indices()->refresh();
    }

    /**
     * Defines index mapping for test index.
     * Override this function in your test case and return array with mapping body.
     * More info check here: https://goo.gl/zWBree
     *
     * @return array Mapping body
     */
    protected function getMapping()
    {
        return [];
    }

    /**
     * Can be overwritten in child class to populate elasticsearch index with the data.
     *
     * Example:
     *      [
     *          'type_name' => [
     *              'custom_id' => [
     *                  'title' => 'foo',
     *              ],
     *              3 => [
     *                  '_id' => 2,
     *                  'title' => 'bar',
     *              ]
     *          ]
     *      ]
     * Document _id can be set as it's id.
     *
     * @return array
     */
    protected function getDataArray()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->deleteIndex();
    }

    /**
     * Execute search to the elasticsearch and handle results.
     *
     * @param Search $search Search object.
     * @param null $type Types to search. Can be several types split by comma.
     * @param bool $returnRaw Return raw response from the client.
     * @return array
     */
    protected function executeSearch(Search $search, $type = null, $returnRaw = false)
    {
        $response = $this->client->search(
            array_filter([
                'index' => self::INDEX_NAME,
                'type' => $type,
                'body' => $search->toArray(),
            ])
        );

        if ($returnRaw) {
            return $response;
        }

        $documents = [];

        try {
            foreach ($response['hits']['hits'] as $document) {
                $documents[$document['_id']] = $document['_source'];
            }
        } catch (\Exception $e) {
            return $documents;
        }

        return $documents;
    }

    /**
     * Deletes index from elasticsearch.
     */
    private function deleteIndex()
    {
        try {
            $this->client->indices()->delete(['index' => self::INDEX_NAME]);
        } catch (\Exception $e) {
            // Do nothing.
        }
    }
}
