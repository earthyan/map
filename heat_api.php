<?php
require_once 'conn.php';
require_once 'common.php';
//1为上行 2为下行
$type = isset($_GET['type'])? $_GET['type']:1;
if($type==1){
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

    $desIP_body ='{
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
    $desRes = elSearch($client,$desIP_body);
    $hits = $desRes['aggregations']['desIP']['buckets'];
    $desIPs = array_column($hits,'key');
    $data = [];
    foreach ($sourceIPs as $key=>$value){
        foreach ($desIPs as $k=>$v){
            $x_body = getBody($value,$v,1,'must');
            $res = elSearch($client,$x_body);
            if(!empty($hits = $res['hits']['hits'])){
                $avg = round($hits[0]['_source']['avg']);
                $data[] = array($key,$k,$avg);
            }else{
                $data[] = array($key,$k,'-');
            }
        }
    }
    $result = array(
        'data'=>$data,
        'sourceIP'=>$sourceIPs,
        'desIP'=>$desIPs
    );
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
}else{
    $desIP_body ='{
	"from": 0,
	"size": 0,
	"aggregations": {
		"desIP": {
			"terms": {
				"field": "desIP",
				"size": 10
			}
		}
	}
}';
    $sourceIpRes = elSearch($client,$desIP_body);
    $hits = $sourceIpRes['aggregations']['desIP']['buckets'];
    $desIPs = array_column($hits,'key');

    $sourceIP_body ='{
	"from": 0,
	"size": 0,
	"aggregations": {
		"desIP": {
			"terms": {
				"field": "sourceIP",
				"size": 10,
				"shard_size": 2000
			}
		}
	}
}';
    $sourceRes = elSearch($client,$sourceIP_body);
    $hits = $sourceRes['aggregations']['desIP']['buckets'];
    $sourceIPs = array_column($hits,'key');
    $data = [];
    foreach ($desIPs as $key=>$value){
        foreach ($sourceIPs as $k=>$v){
            $x_body = getBody($value,$v,1,'must');
            $res = elSearch($client,$x_body);
            if(!empty($hits = $res['hits']['hits'])){
                $avg = round($hits[0]['_source']['avg']);
                $data[] = array($key,$k,$avg);
            }else{
                $data[] = array($key,$k,'-');
            }
        }
    }
    $result = array(
        'data'=>$data,
        'desIP'=>$desIPs,
        'sourceIP'=>$sourceIPs
    );
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
}









