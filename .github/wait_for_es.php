<?php

use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\NoNodesAvailableException;

require dirname(__DIR__) . '/vendor/autoload.php';

$retries = 0;
$maxRetries = 10;

while (true) {
    try {
        $client = ClientBuilder::create()->build();
        $client->ping();
        echo 'Is up and running' . PHP_EOL;
        exit(0);
    } catch (NoNodesAvailableException $e) {
        if ($retries === $maxRetries) {
            echo 'Cannot reach elasticsearch server' . PHP_EOL;
            exit(1);
        }

        sleep(5);
        $retries++;
    }
}
