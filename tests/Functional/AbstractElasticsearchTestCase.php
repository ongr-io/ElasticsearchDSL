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

abstract class AbstractElasticsearchTestCase extends \PHPUnit_Framework_TestCase
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
    protected function setUp()
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

    private function deleteIndex()
    {
        try {
            $this->client->indices()->delete(['index' => self::INDEX_NAME]);
        } catch (\Exception $e) {
            // Do nothing.
        }
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
    protected function tearDown()
    {
        parent::tearDown();
        $this->deleteIndex();
    }

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
}
