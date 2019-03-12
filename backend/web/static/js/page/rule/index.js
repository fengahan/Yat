layui.use(['layer','table'],function(){

    var layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        table = layui.table;
    //角色列表
    var ruleTable=  table.render({
        elem: '#rule',
        url : ruleListUrl,
        cellMinWidth : 95,
        height : "full-20",
        cols : [[
            {field: 'name', title: '名称', width:200},
            {field: 'className', title: 'className',  align:'left',width:350},
            {field: 'updatedAt', title: '更新时间',  align:'left',minWidth:50},
            {field: 'createdAt', title: '创建时间',  align:'left',minWidth:50},
            {title: '操作', minWidth:175, templet:'#ruleListBar',fixed:"right",align:"center"}
        ]]
    });

    $(".addNewRule_btn").click(function(){

        var index = layui.layer.open({
            title : "添加规则",
            type :2,
            content :ruleCreateUrl,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回规则列表', '.layui-layer-setwin .layui-layer-close', {
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

    function  updateRuleInfo(name){
        var index = layui.layer.open({
            title : "编辑规则",
            type :2,
            content :ruleUpdateUrl+"?rule_name="+name,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回规则列表', '.layui-layer-setwin .layui-layer-close', {
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
    table.on('tool(rule)', function(obj){

        var layEvent = obj.event,
            data = obj.data;
        if(layEvent === 'update'){ //编辑
            updateRuleInfo(data.name)
        } else if(layEvent === 'delete'){ //删除
            layer.confirm('确定删除此规则？',{icon:3, title:'提示信息'},function(index){
                $.post(ruleDeleteUrl,{
                    rule_name:data.name
                },function(res){
                    if (res.status==1){
                        layer.msg(res.msg, {icon: 1});
                        ruleTable.reload();
                    }else {
                        layer.msg(res.msg, {icon: 5});
                    }
                })
            });
        }
    });



});

