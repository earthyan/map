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
				"size": 20
			}
		}
	}
}';
$sourceIpRes = elSearch($client,$sourceIP_body);
$hits = $sourceIpRes['aggregations']['sourceIP']['buckets'];
$sourceIPs = json_encode(array_column($hits,'key'));
?>
<!DOCTYPE html>
<html style="height: 100%">
<head>
    <meta charset="utf-8">
    <title>地图</title>
</head>
<body style="height: 100%; margin: 0">
<div id="container" style="height: 100%"></div>
<script type="text/javascript" src="./static/js/jquery.js"></script>
<script type="text/javascript" src="./static/js/echarts.min.js"></script>
<script type="text/javascript" src="./static/js/echarts-gl.min.js"></script>
<script type="text/javascript" src="./static/js/ecStat.min.js"></script>
<script type="text/javascript" src="./static/js/dataTool.min.js"></script>
<script type="text/javascript" src="./static/js/china.js"></script>
<script type="text/javascript" src="./static/js/world.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ZUONbpqGBsYGXNIYHicvbAbM"></script>
<script type="text/javascript" src="./static/js/bmap.min.js"></script>
<script type="text/javascript" src="./static/js/simplex.js"></script>
<script type="text/javascript">
    var dom = document.getElementById("container");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    var ips = <?php echo $sourceIPs;?>;
    console.log(ips);
    api(ips[0]);

    function api(ip){
        $.getJSON('./map_api.php',{'ip': ip}, function(data) {
            console.log(data);
            myChart.setOption({
                backgroundColor: '#000',
                globe: {
                    baseTexture: './static/img/earth.jpg',
                    heightTexture: './static/img/bathymetry_bw_composite_4k.jpg',

                    shading: 'lambert',

                    light: {
                        ambient: {
                            intensity: 0.5
                        },
                        main: {
                            intensity: 0.5
                        }
                    },

                    viewControl: {
                        autoRotate: true,
                        autoRotateSpeed: 16,
                    }
                },
                series: {

                    type: 'lines3D',

                    coordinateSystem: 'globe',

                    blendMode: 'lighter',

                    effect: {
                        show: true,
                        period: 10,
                        symbol: 'arrow',
                        symbolSize: 100000
                    },

                    // lineStyle: {
                    //     width: 1,
                    //     color: '#FFB90F',
                    //     opacity: 0.2
                    // },

                    data: data
                }
            });
        });
    }
    var index=1;
    setInterval(function () {
        api(ips[index]);
        if(index<ips.length-1){
            index++;
        }else{
            index=0
        }
    },12000);

</script>
</body>
</html>