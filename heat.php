<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>热力图</title>
    <!-- 引入 echarts.js -->
    <script src="./static/js/echarts.min.js"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#up" data-toggle="tab">
            上行</a></li>
    <li><a href="#down" data-toggle="tab">下行</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="up">
        <div id="main" style="width: 1600px;height:800px;margin: auto"></div>
    </div>
    <div class="tab-pane fade" id="down">
        <div id="main1" style="width: 1600px;height:800px;margin: auto"></div>
    </div>
</div>
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->

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
<script>
    $(function(){
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // 获取已激活的标签页的名称
            var activeTab = $(e.target).text();
            // 获取前一个激活的标签页的名称
            var previousTab = $(e.relatedTarget).text();
            $(".active-tab span").html(activeTab);
            $(".previous-tab span").html(previousTab);
        });
    });
</script>
</body>
</html>



