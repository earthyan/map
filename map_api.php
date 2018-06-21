<?php
require_once 'conn.php';
require_once 'common.php';

$ip = trim($_GET['ip']);
$body = getBody($ip,$ip,200,'should');


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
        $avg = $source['avg'];
        if($avg<200){
            $color = '#0000FF';//蓝
        }elseif ($avg>200 && $avg <500){
            $color = '#FFFF00';//黄
        }else{
            $color = '#FF0000';//红
        }
        $lineStyle  = array(
            'width'=>0.8,
            'color'=>$color,
            'opacity'=>0.8,
        );
        $routes[] = array(
            'coords'=> array([$source['slng'],$source['sLat']],[$source['dlng'],$source['dlat']]),
            'value'=>$avg,
            'name'=>'foo',
            'lineStyle'=>$lineStyle,
        );
    }
    echo  json_encode($routes,JSON_UNESCAPED_UNICODE);
} catch (\Exception $e) {
    echo $e->getMessage();
}



