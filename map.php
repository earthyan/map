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
    $.getJSON('./static/data/flights.json', function(data) {

        function getAirportCoord(idx) {
            return [data.airports[idx][3], data.airports[idx][4]];
        }
        var routes = data.routes.map(function(airline) {
            return [
                getAirportCoord(airline[1]),
                getAirportCoord(airline[2])
            ];
        });

        myChart.setOption({
            backgroundColor: '#000',
            globe: {
                baseTexture: './static/img/earth.jpg',
                heightTexture: './static/img/bathymetry_bw_composite_4k.jpg',

                shading: 'lambert',

                light: {
                    ambient: {
                        intensity: 0.4
                    },
                    main: {
                        intensity: 0.4
                    }
                },

                viewControl: {
                    autoRotate: false
                }
            },
            series: {

                type: 'lines3D',

                coordinateSystem: 'globe',

                blendMode: 'lighter',

                lineStyle: {
                    width: 1,
                    color: 'rgb(50, 50, 150)',
                    opacity: 0.1
                },

                data: routes
            }
        });
    });;
    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }
</script>
</body>
</html>