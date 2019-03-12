layui.use('table', function(){
    var table = layui.table,$ = layui.$;
    var height = 490; //固定表格高度
    //计算按钮的高度
    var btn_height = height /2 -44;
    $('.btn-height').css('padding-top',btn_height).css('text-align','center')
    //左边表格
    table.render({
        elem: '#left_tab'
        ,url: permissionAllUrl
        ,where:{role_name:role_name}
        ,cols: [[
            {checkbox: true, fixed: true}
            ,{field:'name',title:'Id'}
            ,{field:'ext_name', title: '名称'}
            ,{field:'type', title: '类别'}
            ,{field:'description', title: '描述'}

        ]]
        ,id: 'left_table_id'
        ,height: height
    });
    //右边表格
    table.render({
        elem: '#right_tab'
        ,url: permissionAssUrl
        ,where:{role_name:role_name}
        ,cols: [[
            {checkbox: true, fixed: true}
            ,{field:'name',title:'Id'}
            ,{field:'ext_name', title: '名称'}
            ,{field:'type', title: '类别'}
            ,{field:'description', title: '描述'}

        ]]
        ,data: []
        ,id: 'right_table_id'
        ,height: height
    });
    //公共方法
    function getTableData(name){
        var checkStatus = table.checkStatus(name)
            ,data = checkStatus.data;
        return data;
    }
    function btnIf(data,btn){
        if(data && data.length){
            $(btn).removeClass('layui-btn-disabled')
        }else{
            $(btn).addClass('layui-btn-disabled')
        }
    }
    //重载左边表格
    function reloadTable() {
        table.reload('left_table_id');
        table.reload('right_table_id');
    }
    //监听左表格选中
    table.on('checkbox(left)', function(obj){
        btnIf(getTableData('left_table_id'),'.left-btn')
    });
    //监听右表格选中
    table.on('checkbox(right)', function(obj){
        btnIf(getTableData('right_table_id'),'.right-btn')
    });
    //左按钮点击移动数据
    $('.left-btn').on('click',function(){
        if(!$(this).hasClass('layui-btn-disabled')){
            $('.left-btn,.right-btn').addClass('layui-btn-disabled')
            var data = getTableData('left_table_id');
            var items =  new Array();
            $.each(data,function(k,v){
                items.push(v.name)
            });
            var indexLoad =layer.msg('稍等一下', {
                icon: 16
                ,shade: 0.01
            });
            $.post(permissionAssignUrl,{
                role_name:role_name,
                items:items
            },function(res){
                if (res.status==1){
                    setTimeout(reloadTable(),3000)
                    layer.close(indexLoad)
                    layer.msg(res.msg, {icon: 1});
                }else {
                    layer.close(indexLoad)
                    layer.msg(res.msg, {icon: 5});
                }
            })
        }
    })
    //右按钮点击移动数据
    $('.right-btn').on('click',function () {
        if(!$(this).hasClass('layui-btn-disabled')){
            $('.left-btn,.right-btn').addClass('layui-btn-disabled')
            var data = getTableData('right_table_id');
            var items =  new Array();
            $.each(data,function(k,v){
                items.push(v.name)
            });
            var indexLoad =layer.msg('稍等一下', {
                icon: 16
                ,shade: 0.01
            });
            $.post(permissionRemoveUrl,{
                role_name:role_name,
                items:items
            },function(res){
                if (res.status==1){
                    setTimeout(reloadTable(),3000)
                    layer.close(indexLoad)
                    layer.msg(res.msg, {icon: 1});
                }else {
                    layer.close(indexLoad)
                    layer.msg(res.msg, {icon: 5});
                }
            })


        }
    })
});