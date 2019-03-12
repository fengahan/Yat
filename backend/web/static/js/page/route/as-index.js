layui.use(['layer','table'],function(){

    var layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        table = layui.table;
    //可执行路由
   var routeTable=  table.render({
        elem: '#assigned',
        url : routeAssignedListUrl,
        cellMinWidth : 95,
        page : true,
        height : "full-20",
        limit : 20,
        limits : [10,15,20,25],
        cols : [[
            {type: "checkbox", fixed:"left", width:50},
            {field: 'name', title: '请求地址', width:100},
            {field: 'route_name', title: '名称',  align:'left',minWidth:50},
            {field: 'route_description', title: '简述',  align:'left',minWidth:150},
            {field: 'updated_at', title: '更新时间',  align:'left',minWidth:50},
            {field: 'created_at', title: '创建时间',  align:'left',minWidth:50},
            {title: '操作', minWidth:175, templet:'#routeListBar',fixed:"right",align:"center"}
        ]]
    });
    //批量删除
    $(".remove_btn").click(function(){

        var checkStatus = table.checkStatus('assigned'),

            data = checkStatus.data,
            routes = [];
        if(data.length > 0) {
            for (var i in data) {
                routes.push(data[i].name);
            }
            layer.confirm('确定删除？', {icon: 3, title: '提示信息'}, function (index) {
                $.post(routeRemoveUrl,{
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
            layer.msg("请选择需要移除的路由");
        }
    });
    //批量删除
    $(".addNewRoute_btn").click(function(){

        var index = layui.layer.open({
            title : "添加路由",
            type :2,
            content :routeCreateUrl,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回路由列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            }
        })
        layui.layer.full(index);
        window.sessionStorage.setItem("index",index);
        $(window).on("resize",function(){
            layui.layer.full(window.sessionStorage.getItem("index"));
        })
    });
    //编辑路由
    function updateRouteInfo(name){
        var index = layui.layer.open({
            title : "编辑路由",
            type :2,
            content :routeUpdateUrl+"?route_name="+name,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回路由列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            }
        })
        layui.layer.full(index);
        window.sessionStorage.setItem("index",index);
        $(window).on("resize",function(){
            layui.layer.full(window.sessionStorage.getItem("index"));
        })
    }
    //列表操作
    table.on('tool(assigned)', function(obj){

        var layEvent = obj.event,
            data = obj.data;
        if(layEvent === 'update'){ //编辑
           updateRouteInfo(data.name)
        } else if(layEvent === 'delete'){ //删除
            layer.confirm('确定删除此路由？',{icon:3, title:'提示信息'},function(index){
               $.post(routeRemoveUrl,{
                     routes:[data.name]  //将需要删除的newsId作为参数传入
                },function(res){
                  if (res.status==1){
                      layer.msg(res.msg, {icon: 1});
                      routeTable.reload();
                  }else {
                      layer.msg(res.msg, {icon: 5});
                  }
                })
            });
        }
    });



});

