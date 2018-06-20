<?php


function getBody($sourceIP,$desIP,$size=200,$type='must'){
    $x_body = array(
        'from'=>0,
        'size'=>$size,
        'query'=>array(
            'bool'=>array(
                'must'=>array(
                    'bool'=>array(
                        $type=>array(
                            array(
                                'match'=>array(
                                    'desIP'=>array(
                                        'query'=>$desIP,
                                        'type'=>'phrase'
                                    )
                                )
                            ),
                            array(
                                'match'=>array(
                                    'sourceIP'=>array(
                                        'query'=>$sourceIP,
                                        'type'=>'phrase'
                                    )
                                )
                            )
                        )
                    )
                ),
            )
        ),
        'sort'=> array(
            array(
                'timestamp'=>array(
                    'order'=>'desc'
                )
            ),
        ),
    );
    return $x_body;
}



function elSearch($client,$body){
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
        return $response;
    } catch (\Exception $e) {
        return  $e->getMessage();
    }
}