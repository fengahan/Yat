layui.use(['layer','table'],function(){

    var layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        table = layui.table;
    //角色列表
    var roleTable=  table.render({
        elem: '#role',
        url : roleListUrl,
        cellMinWidth : 95,
        height : "full-20",
        cols : [[
            {type: "checkbox", fixed:"left", width:50},
            {field: 'name', title: '名称', width:200},
            {field: 'ruleName', title: '规则名称',  align:'left',minWidth:50},
            {field: 'description', title: '简述',  align:'left',minWidth:150},
            {field: 'data', title: '扩展数据',  align:'left',minWidth:50},
            {field: 'updatedAt', title: '更新时间',  align:'left',minWidth:50},
            {field: 'createdAt', title: '创建时间',  align:'left',minWidth:50},
            {title: '操作', minWidth:175, templet:'#roleListBar',fixed:"right",align:"center"}
        ]]
    });

    $(".addNewRole_btn").click(function(){

        var index = layui.layer.open({
            title : "添加角色",
            type :2,
            content :roleCreateUrl,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回角色列表', '.layui-layer-setwin .layui-layer-close', {
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

    function  updateRoleInfo(name){
        var index = layui.layer.open({
            title : "编辑角色",
            type :2,
            content :roleUpdateUrl+"?role_name="+name,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回角色列表', '.layui-layer-setwin .layui-layer-close', {
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
    function viewRole(name){
        var index = layui.layer.open({
            title : "查看角色",
            type :2,
            content :roleViewUrl+"?role_name="+name,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回角色列表', '.layui-layer-setwin .layui-layer-close', {
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
    table.on('tool(role)', function(obj){

        var layEvent = obj.event,
            data = obj.data;
        if(layEvent === 'update'){ //编辑
            updateRoleInfo(data.name)
        } else if(layEvent === 'delete'){ //删除
            layer.confirm('确定删除此角色？',{icon:3, title:'提示信息'},function(index){
                $.post(roleDeleteUrl,{
                    role_name:data.name
                },function(res){
                    if (res.status==1){
                        layer.msg(res.msg, {icon: 1});
                        roleTable.reload();
                    }else {
                        layer.msg(res.msg, {icon: 5});
                    }
                })
            });
        }else if (layEvent=='view'){
            viewRole(data.name)
        }
    });



});

