var form;
layui.use(['layer','table','form'],function(){
    var layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        form = layui.form;
        var table = layui.table;
    //角色列表
    var ruleTable=  table.render({
        elem: '#adminUser',
        url : adminUserList,
        cellMinWidth : 95,
        limit : 20,
        height : "full-20",
        cols : [[
            {field: 'id', title: 'Id', width:80},
            {field: 'head_img', title: '头像', width:80, align:"center",templet:function(d){
                    return '<img class="layui-circle" src="'+d.head_img+'" height="26"/>';
                }},
            {field: 'username', title: '帐号',  align:'left',width:100},
            {field: 'nickname', title: '真实姓名', width:100},
            {field: 'email', title: '邮箱', width:100},
            {field: 'status', title:'状态', width:120, templet: '#statusTpl', unresize: true},
            {field: 'last_login_at', title: '上次登录时间',  align:'left',minWidth:50},
            {field: 'updated_at', title: '更新时间',  align:'left',minWidth:50},
            {field: 'created_at', title: '创建时间',  align:'left',minWidth:50},
            {title: '操作', minWidth:175, templet:'#adminUserListBar',fixed:"right",align:"center"}
        ]]
    });

    $(".addNewAdminUser_btn").click(function(){

        var index = layui.layer.open({
            title : "添加管理员",
            type :2,
            content :adminUserCreateUrl,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回管理员列表', '.layui-layer-setwin .layui-layer-close', {
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

    function  updateAdminUserInfo(id){
        var index = layui.layer.open({
            title : "编辑管理员",
            type :2,
            content :adminUserUpdateUrl+"?admin_user_id="+id,
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回管理员列表', '.layui-layer-setwin .layui-layer-close', {
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
    table.on('tool(adminUser)', function(obj){

        var layEvent = obj.event,
            data = obj.data;
        if(layEvent === 'update'){ //编辑
            updateAdminUserInfo(data.id)
        } else if(layEvent === 'delete'){ //删除
            layer.confirm('确定删除此管理员？',{icon:3, title:'提示信息'},function(index){
                $.post(adminUserDeleteUrl,{
                    admin_user_id:data.id
                },function(res){
                    if (res.status==1){
                        layer.msg(res.msg,{icon: 1});
                        ruleTable.reload();
                    }else {
                        layer.msg(res.msg, {icon: 5});
                    }
                })
            });
        }
    });
    //更改状态按钮
    form.on('switch(statusSwitch)', function(data){
            layer.confirm('确定进行修改吗？',{icon:3, title:'提示信息'},function(index){
                 var admin_user_id=  data.value;
                $.post(adminUserUpdateStatusUrl,{
                    admin_user_id:admin_user_id,
                },function(res){
                    if (res.status==1){
                        layer.msg(res.msg, {icon: 1});
                    }else {
                        ruleTable.reload();
                        layer.msg(res.msg, {icon: 5});
                    }
                })
            });
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });
});

