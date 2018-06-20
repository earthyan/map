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
<div id="main" style="width: 1200px;height:600px; margin: auto"></div>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    $.get('./line_api.php').done(function (data) {
        data = JSON.parse(data);
        series = data;
        console.log(data);
        // 指定图表的配置项和数据
        option = {
            title: {
                text: '服务器负载折线图'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['最大值','最小值','平均值']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: ['一','二','三','四','五','六','七','八','九','十']
            },
            yAxis: {
                type: 'value'
            },
            series: series
        };
        myChart.setOption(option);
    });
</script>
</body>
</html>