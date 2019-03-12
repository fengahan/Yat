layui.use(['layer','table'],function(){
    var countAv=0;
    var layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        table = layui.table;
    //系统路由
   var routeTable=  table.render({
        elem: '#assign',
        url : routeAvailableListUrl,
        cellMinWidth : 95,
        page : true,
        height : "full-20",
        limit : 20,
        limits : [10,15,20,25],
        cols : [[
            {type: "checkbox", fixed:"left", width:50},
            {field: 'route', title: '请求地址', width:220},
            {field: 'route_name', title: '名称',  align:'left',minWidth:50},
            {field: 'route_description', title: '简述',  align:'left',minWidth:250},
        ]],
       done: function(res, curr, count){
           //得到数据总量
           countAv=count;
       }
    });
    //批量添加
    $(".assign_btn").click(function(){
        var checkStatus = table.checkStatus('assign'),
            data = checkStatus.data,
            routes = [];
        if(data.length > 0) {
            for (var i in data) {
                routes.push(data[i].route);
            }
            layer.confirm('确定添加到可用？', {icon: 3, title: '提示信息'}, function (index) {
                $.post(routeAssignUrl,{
                   routes : routes
                },function(data){
                    if (data.status==1){
                        layer.msg(data.msg, {icon: 1});
                        routeTable.reload();
                    }else {
                        layer.msg('操作失败了哦。。', {icon: 5});
                    }
                    layer.close(index);
                 })
            })
        }else{
            layer.msg("请选择需要添加的路由");
        }
    });
    //全部添加
    $(".assignAll_btn").click(function(){
        if (countAv<1){
            layer.msg("没有可以添加的路由哦");
            return
        }
        layer.confirm('确定添加全部到可用？', {icon: 3, title: '提示信息'}, function (index) {
            $.post(routeAssignUrl,{
                all : 1  //将需要删除的newsId作为参数传入
            },function(data){
                if (data.status==1){
                    layer.msg('操作成功', {icon:1});
                    routeTable.reload();
                }else {
                    layer.msg('操作失败了哦。。', {icon: 5});
                }

            });
            layer.close(index);
        })

    });


});

