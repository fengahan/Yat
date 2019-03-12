var form;
var tableSelect;
layui.config({
    base: '/static/plugins/layui-extend'
}).extend({
    tableSelect:'/tableSelect/tableSelect',
    iconPicker: '/iconPicker/iconPicker',

}).use(['form','layer','tableSelect','iconPicker'],function(){
    var iconPicker = layui.iconPicker,
    form = layui.form;
    $ = layui.jquery;
    tableSelect = layui.tableSelect;
    var layer = parent.layer === undefined ? layui.layer : top.layer;
    tableSelect.render({
        elem: '#route-select',	//定义输入框input对象
        checkedKey: 'name',//表格的唯一建值，非常重要，影响到选中状态 必填
      //  searchKey: 'name',	//搜索输入框的name值 默认keyword
        searchPlaceholder: '路由地址搜索',	//搜索输入框的提示文字 默认关键词搜索
        table: {	//定义表格参数，与LAYUI的TABLE模块一致，只是无需再定义表格elem
            url : routeAssignedListUrl,
            limit : 20,
            limits : [10,15,20,25],
            cols : [[
                { type: 'radio' },
                {field: 'name', title: '请求地址',minWidth:50},
                {field: 'route_name', title: '名称',  align:'left',minWidth:50},
                {field: 'route_description', title: '简述',  align:'left', minWidth:100}
                ]]
        },
        done: function (elem, data) {
           elem.val(data.data[0].name)
        }
    })

    iconPicker.render({
        // 选择器，推荐使用input
        elem: '#iconPicker',
        // 数据类型：fontClass/unicode，推荐使用fontClass
        type: 'fontClass',
        // 是否开启搜索：true/false
        search:false,
        // 是否开启分页
        page: true,
        // 每页显示数量，默认24
        limit: 24,
        // 点击回调
        click: function (data) {
            console.log(data)
        },
        // 渲染成功后的回调
        success: function(d) {
            $('#iconPicker').val('iconpicker');
        }
    });
    iconPicker.checkIcon('iconPicker', 'layui-icon-star-fill');
    //添加菜单
    form.on("submit(createMenu)",function(data){
        var index = layer.msg('提交中，请稍候',{icon: 16,time:false,shade:0.8});
        setTimeout(function(){
            $.post(menuCreateUrl,{
                name:data.field.name,
                route:data.field.route,
                icon:data.field.icon,
                order:data.field.order,
                parent_id:data.field.parent_id
            },function(res){
                if (res.status==1){
                    parent.location.reload();
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

