<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>折线图</title>
    <!-- 引入 echarts.js -->
    <script src="./static/js/echarts.min.js"></script>
    <script src="./static/js/jquery.js"></script>
</head>
<body>
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="width: 1400px;height:700px; margin: auto"></div>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    var timeData = [
        '2009/6/13 0:00', '2009/6/13 1:00', '2009/6/13 2:00', '2009/6/13 3:00', '2009/6/13 4:00', '2009/6/13 5:00', '2009/6/13 6:00', '2009/6/13 7:00', '2009/6/13 8:00', '2009/6/13 9:00', '2009/6/13 10:00', '2009/6/13 11:00', '2009/6/13 12:00', '2009/6/13 13:00', '2009/6/13 14:00', '2009/6/13 15:00', '2009/6/13 16:00', '2009/6/13 17:00', '2009/6/13 18:00', '2009/6/13 19:00', '2009/6/13 20:00', '2009/6/13 21:00', '2009/6/13 22:00', '2009/6/13 23:00',
    ];

    timeData = timeData.map(function (str) {
        return str.replace('2009/', '');
    });
    console.log(timeData);

    option = {
        title: {
            text: '服务器关系图',
            subtext: '',
            x: 'center'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                animation: false
            }
        },
        legend: {
            data:['流量','降雨量'],
            x: 'left'
        },
        toolbox: {
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                restore: {},
                saveAsImage: {}
            }
        },
        axisPointer: {
            link: {xAxisIndex: 'all'}
        },
        dataZoom: [
            {
                show: true,
                realtime: true,
                start: 0,
                end: 100,
                xAxisIndex: [0, 1]
            },
            {
                type: 'inside',
                realtime: true,
                start: 0,
                end: 100,
                xAxisIndex: [0, 1]
            }
        ],
        grid: [{
            left: 50,
            right: 50,
            height: '35%'
        }, {
            left: 50,
            right: 50,
            top: '55%',
            height: '35%'
        }],
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                axisLine: {onZero: true},
                data: timeData
            },
            {
                gridIndex: 1,
                type : 'category',
                boundaryGap : false,
                axisLine: {onZero: true},
                data: timeData,
                position: 'top'
            }
        ],
        yAxis : [
            {
                name : '上行',
                type : 'value',
                max : 500
            },
            {
                gridIndex: 1,
                name : '下行',
                type : 'value',
                inverse: true
            }
        ],
        series : [
            {
                name:'上行',
                type:'line',
                symbolSize: 8,
                hoverAnimation: false,
                data:[
                     1,23,43,58,23,3,5,2,2,6,22,52,2,52,25,2,32,2,23,2,23,5,4,3,3,6,3,33,63,23,22,2,2
                ]
            },
            {
                name:'下行',
                type:'line',
                xAxisIndex: 1,
                yAxisIndex: 1,
                symbolSize: 8,
                hoverAnimation: false,
                data: [
                    1,2,3,4,5,6,7,8,3,5,423,43,35,5,5,2,4,4,6,3,34,35,25,2,3,3,56,6,6
                ]
            }
        ]
    };
    myChart.setOption(option);

</script>
</body>
</html>