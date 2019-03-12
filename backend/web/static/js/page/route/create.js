var form;
layui.use(['form','layer'],function(){
    form = layui.form;
    $ = layui.jquery;
    var layer = parent.layer === undefined ? layui.layer : top.layer;

    //修改路由
    form.on("submit(createRoute)",function(data){
        var index = layer.msg('提交中，请稍候',{icon: 16,time:false,shade:0.8});
        setTimeout(function(){


                $.post(routeCreateUrl,{
                    name:data.field.name,
                    data_name:data.field.data_name,
                    data_description:data.field.data_description,
                },function(res){
                    if (res.status==1){
                        layer.msg(res.msg, {icon: 1});
                    }else {
                        layer.msg(res.msg, {icon: 5});
                    }
                })
            layer.close(index);

        },2000);
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    })
})