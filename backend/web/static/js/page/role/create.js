var form;
var tableSelect;
layui.config({
    base: '/static/plugins/layui-extend'
}).extend({
    tableSelect:'/tableSelect/tableSelect',
}).use(['form','layer','tableSelect'],function(){
    form = layui.form;
    $ = layui.jquery;
    tableSelect = layui.tableSelect;
    var layer = parent.layer === undefined ? layui.layer : top.layer;
    tableSelect.render({
        elem: '#rule-name-select',	//定义输入框input对象
        checkedKey: 'name',//表格的唯一建值，非常重要，影响到选中状态 必填
        table: {	//定义表格参数，与LAYUI的TABLE模块一致，只是无需再定义表格elem
            url :ruleListUrl,
            limit : 20,
            limits : [10,15,20,25],
            cols : [[
                { type: 'radio' },
                {field: 'name', title: '名称', width:100},
                {field: 'className', title: 'className',  align:'left',width:150},
                {field: 'updatedAt', title: '更新时间',  align:'left',minWidth:50},
            ]]
        },
        done: function (elem, data) {
            elem.val(data.data[0].name)
        }
    })
    //修改角色
    form.on("submit(createRole)",function(data){
        var index = layer.msg('提交中，请稍候',{icon: 16,time:false,shade:0.8});
        setTimeout(function(){
                $.post(roleCreateUrl,{
                    name:data.field.name,
                    ruleName:data.field.ruleName,
                    data:data.field.data,
                    description:data.field.description,
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