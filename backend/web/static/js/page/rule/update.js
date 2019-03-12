var form;
layui.use(['form','layer'],function(){
    form = layui.form;
    $ = layui.jquery;
    var layer = parent.layer === undefined ? layui.layer : top.layer;

    //修改路由
    form.on("submit(updateRule)",function(data){
        var index = layer.msg('提交中，请稍候',{icon: 16,time:false,shade:0.8});
        setTimeout(function(){
            layer.close(index);
            layer.confirm('确定进行修改吗？',{icon:3, title:'提示信息'},function(index){
                $.post(ruleUpdateUrl,{
                    name:data.field.name,
                    rule_name:data.field.rule_name,
                    className:data.field.className,
                },function(res){
                    if (res.status==1){
                        layer.msg(res.msg, {icon: 1});
                        parent.location.reload();
                    }else {
                        layer.msg(res.msg, {icon: 5});
                    }
                })
            });

        },2000);
        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    })
})