<?php
require_once 'conn.php';
require_once 'common.php';
$sourceIP_body ='{
	"from": 0,
	"size": 0,
	"aggregations": {
		"sourceIP": {
			"terms": {
				"field": "sourceIP",
				"size": 10
			}
		}
	}
}';
$sourceIpRes = elSearch($client,$sourceIP_body);
$hits = $sourceIpRes['aggregations']['sourceIP']['buckets'];
$sourceIPs = array_column($hits,'key');
$sourceIP = $sourceIPs[0];
$desIP = $sourceIPs[0];
$body = getBody($sourceIP,$desIP,10,'should');
$res = elSearch($client,$body);
$hits = $res['hits']['hits'];
$max = [];
$min = [];
$avg = [];
foreach ($hits as $hit){
    $max[] = $hit['_source']['max'];
    $min[] = $hit['_source']['min'];
    $avg[] = $hit['_source']['avg'];
}

echo json_encode(array(
    array('name'=>'最大值','type'=>'line','stack'=>'总量','data'=>$max),
    array('name'=>'最小值','type'=>'line','stack'=>'总量','data'=>$min),
    array('name'=>'平均值','type'=>'line','stack'=>'总量','data'=>$avg),

),JSON_UNESCAPED_UNICODE);


