<?php
require_once 'conn.php';

$body = array(
    'from'=>0,
    'size'=>5000,
    'query'=>array(
        'bool'=>array(
            'filter'=>array(
                'bool'=>array(
                    'must'=>array(
                        'range'=>array(
                            'timestamp'=>array(
                                'from'=>date('Y-m-d\TH:i:s',time()+8*3600-10*60),
                                'to'=>null,
                                'include_lower'=>false,
                                'include_upper'=>true
                            )
                        )
                    )
                )
            )
        )
    )
);

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
    $hits = $response['hits']['hits'];
    $routes = [];
    foreach ($hits as $hit){
        $source = $hit['_source'];
        $routes[] = array(
            [$source['slng'],$source['sLat']],[$source['dlng'],$source['sLat']]
        );

    }
    echo  json_encode($routes,JSON_UNESCAPED_UNICODE);
} catch (\Exception $e) {
    echo $e->getMessage();
}



