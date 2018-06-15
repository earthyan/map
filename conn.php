<?php
require_once './vendor/autoload.php';
use Elasticsearch\ClientBuilder;

$hosts = [
    'idcpinges.watch.11ops.com:80'
];
$client = ClientBuilder::create()->setHosts($hosts)->build();
