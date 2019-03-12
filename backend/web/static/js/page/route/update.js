var form;
layui.use(['form','layer'],function(){
    form = layui.form;
    $ = layui.jquery;
    var layer = parent.layer === undefined ? layui.layer : top.layer;

    //修改路由
    form.on("submit(updateRoute)",function(data){
        var index = layer.msg('提交中，请稍候',{icon: 16,time:false,shade:0.8});
        setTimeout(function(){
            layer.close(index);
            layer.confirm('确定进行修改吗？',{icon:3, title:'提示信息'},function(index){
                $.post(routeUpdateUrl,{
                    route_name:data.field.name,
                    data_name:data.field.data_name,
                    data_description:data.field.data_description,
                },function(res){
                    if (res.status==1){
                        layer.msg(res.msg, {icon: 1});
                    }else {
                        layer.msg(res.msg, {icon: 5});
                    }
                })
            });

        },2000);
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    })
})