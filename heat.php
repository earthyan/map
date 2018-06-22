<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>热力图</title>
    <!-- 引入 echarts.js -->
    <script src="./static/js/echarts.min.js"></script>
    <script src="./static/js/jquery.js"></script>
</head>
<body>
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<h2 style="text-align:center">上行</h2>
<div id="main" style="width: 1600px;height:800px;margin: auto"></div>
<h2 style="text-align:center">下行</h2>
<div id="main1" style="width: 1600px;height:800px;margin: auto"></div>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    var myChart1 = echarts.init(document.getElementById('main1'));
    api(1,myChart);
    api(2,myChart1);
    // 指定图表的配置项和数据
    function api(type,chart){
        $.getJSON('./heat_api.php',{'type': type}, function(data) {
            console.log(data);
            if(type===1){
                hours = data.sourceIP;
                days = data.desIP;
            }else{
                hours = data.desIP;
                days = data.sourceIP;
            }
            data = data.data;
            option = {
                tooltip: {
                    position: 'top'
                },
                animation: false,
                grid: {
                    height: '50%',
                    y: '10%'
                },
                xAxis: {
                    type: 'category',
                    data: hours,
                    splitArea: {
                        show: true
                    }
                },
                yAxis: {
                    type: 'category',
                    data: days,
                    splitArea: {
                        show: true
                    }
                },
                visualMap: {
                    min: 0,
                    max: 500,
                    calculable: true,
                    orient: 'horizontal',
                    left: 'center',
                    bottom: '15%',
                    inRange: {
                        color: ['green','#FFC125', 'red'],
                        symbolSize: [60, 200]
                    },
                },
                series: [{
                    name: 'Value',
                    type: 'heatmap',
                    data: data,
                    label: {
                        normal: {
                            show: true
                        }
                    },
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        },

                    }
                }]
            };
            chart.setOption(option);
        });

    }


</script>
</body>
</html>



