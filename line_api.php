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

$ip = '118.89.140.128';

$body = '{
	"from": 0,
	"size": 200,
	"query": {
		"bool": {
			"filter": {
				"bool": { 
					"must": {
						"match": {
							"timestamp": {
								"query": "2018-06-22T10:00:00",
								"type": "phrase"
							}
						}
					}
				}
			}
		}
	}
}';

$body = array(
    'from'=>0,
    'size'=>200,
    'query'=>array(
        'bool'=>array(
            'filter'=>array(
                'bool'=>array(
                    'must'=>array(
                        'match'=>array(
                            'timestamp'=>array(
                                'query'=>$timestamp,
                                'type'=>'phrase'
                            )
                        )
                    )
                )
            )
        )
    ),
);

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




