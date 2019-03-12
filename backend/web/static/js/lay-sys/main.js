var echarts;

$(function () {

    //config的设置是全局的
    layui.config({
        base: '/plugins/layui-extend/' //这是你存放拓展模块的根目录
    });

    layui.use(['form', 'layer', 'element', 'laydate', 'table', 'echarts'], function () {
        var form = layui.form;
        var layer = parent.layer || layui.layer;
        var laydate = layui.laydate;
        var table = layui.table;

        //放到全局对象中给其他方法访问
        window.echarts = layui.echarts;
        //加载饼图
        pieChartLoad();

        //代办事项
        $(".panel a").on("click", function (event) {
            event.preventDefault();
            var _this = $(this);
            var htmlTab = $(_this.html());
            window.parent.addTab(htmlTab.attr('data-url', (_this.attr('data-url') + '?type=' + _this.find('span').attr('id'))));
        });

        //快捷入口
        $('#shortcutEntry a').on('click', function (event) {
            event.preventDefault();
            var _this = $(this);
            window.parent.addTabByUrlTitleIcon(_this.attr('href'), _this.attr('title'), _this.data('icon'));
        });


        top.jqueryAjax({
            type: 'get'
            , url: "/services/data/todoList.json"
            , contentType: 'application/json'
            , data: '{}'
            , dataType: 'json'
            , success: function (result) {
                if (result.code == 200) {
                    var data = result.data;
                    $.each(data, function (index, item) {
                        $("#" + item.name).html(item.value);
                    });
                } else {
                    layer.msg('获取代办事项信息失败。');
                    console.warn(result.msg);
                }
            }
            , error: function (ex) {
                console.warn(ex.responseText);
            }
        });



        layui.laydate.render({
            elem: '#scanDate'
            , value: new Date(new Date().getTime())
            , done: function () {
                pieChartLoad();
            }
        });

    });//layui.use的结束括号

});//jquery的结束括号

function echartStr(names, brower) {
    var myChart = echarts.init(document.getElementById('main'));
    // 指定图表的配置项和数据
    var option = {
        title: {
            text: '某站点用户访问来源',
            subtext: '默认显示当前天',
            x: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: "访问来源:{b}<br/>共{c}条,占比:{d}%。"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: names
        }
        , calculable: true
        , series: [
            {
                name: '扫描批次',
                type: 'pie',
                radius: '55%',
                center: ['50%', '60%'],
                data: brower
            }
        ]
        , toolbox: {
            show: true,
            feature: {
                dataView: { readOnly: false },
                restore: {},
                saveAsImage: {}
            }
        }
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);







    function eConsole(param) {
        //var mes = '【' + param.type + '】';
        if (typeof param.seriesIndex != 'undefined') {
            // mes += '  seriesIndex : ' + param.seriesIndex;
            // mes += '  dataIndex : ' + param.dataIndex;
            if (param.type == 'click') {
                var peiLenght = option.legend.data.length;
                // alert(peiLenght);// 获取总共给分隔的扇形数
                for (var i = 0; i < peiLenght; i++) {
                    //everyClick(param, i, option.legend.data[i], data_url[i])
                    if (param.seriesIndex == 0 && param.dataIndex == i) {

                        renderTodayUserTable(option.legend.data[i]);

                        return;
                    }
                }
            } else {
                //alert("出现了未知的错误");
            }
        }
    }



    myChart.on("click", eConsole);
    myChart.on("hover", eConsole);


};

/**
 * 渲染今日用户访问表格
 * @param {string} chartId 点击的哪一块扇形
 */
function renderTodayUserTable(chartId) {
    top.layuiTable(layui.table, {
        elem: '#scanTable'
        , method: "get"
        , contentType: "application/json"
        , limit: 50
        , limits: [10, 50, 200, 500]
        , page: { theme: '#1E9FFF' }
        , height: 480
        , url: '/services/data/todayUserTable.json'
        , where: {
            batchNumber: chartId
        }
        , cols: [[
            { type: 'numbers', title: "#", minWidth: 70, width: 70 }
            , {
                field: 'area', title: '地区', width: 170, minWidth: 170, sort: true, templet: function (data) {
                    return '<a style="color:blue" href="https://www.baidu.com/s?ie=UTF-8&wd=' + encodeURI(data.area) + '" title="地区" target="_blank">' + data.area + '</a>';
                }
            }
            , {
                title: '访问来源', minWidth: 220, sort: true, templet: function (d) {
                    return chartId;
                }
            }
        ]]
        , done: function (res, curr, count) {
        }
    });
}

//饼图数据加载
function pieChartLoad() {

    var todayDate = (($("#scanDate").val()) || (top.formatDate(new Date().getTime())));

    $("#scanDate").val(todayDate);
    top.jqueryAjax({
        type: 'get'
        , url: "/services/data/todayQuery.json?date=" + todayDate
        , contentType: 'application/json'
        , data: '{}'
        , dataType: 'json'
        , success: function (result) {
            if (result.code == 200) {
                var data = result.data;
                var names = [];
                $.each(data, function (index, item) {
                    names.push(item.name);
                });
                echartStr(names, data);
            } else {
                layer.msg('获取扫描批次信息失败。');
                echartStr([], []);
                console.warn(result.msg);
            }
        },
        complete: function (XMLHttpRequest, textStatus) {

        }
        , error: function (ex) {
            echartStr([], []);
            console.warn(ex.responseText);
        }
    });
}