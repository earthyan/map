<?php
require_once 'conn.php';

$body ='{
	"from": 0,
	"size": 0,
	"aggregations": {
		"desIP": {
			"terms": {
				"field": "desIP",
				"size": 10,
				"shard_size": 2000
			}
		}
	}
}';


try {
    $params = array(
        'index' => 'gnw-'.date('Ymd'),
        'body' => is_array($body)?json_encode($body):$body,
        'client' => [
            'curl' => [
                CURLOPT_HTTPHEADER => [
                    'Content-type: application/json',
                ]
            ]
        ]
    );
    $response = $client->search($params);
    var_dump($response);die;
} catch (\Exception $e) {
    echo $e->getMessage();
}