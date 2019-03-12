var $
var editObj=null,ptable=null,treeGrid=null,tableId='treeTable',layer=null;
layui.config({
    base: '/static/plugins/layui-extend'
}).extend({
    treeGrid:'/treeGrid/treeGrid'
}).use(['jquery','treeGrid','layer'], function(){
    $ =layui.jquery;
    treeGrid = layui.treeGrid;//很重要
    layer=layui.layer;
    ptable=treeGrid.render({
        id:tableId
        ,elem: '#'+tableId
        ,url:'/menu/menu-list'
        ,cellMinWidth: 100
        ,idField:'id'//必須字段
        ,treeId:'id'//树形id字段名称
        ,treeUpId:'parent'//树形父id字段名称
        ,treeShowName:'name'//以树形式显示的字段
        ,heightRemove:[".dHead",10]//不计算的高度,表格设定的是固定高度，此项不生效
        ,height:'100%'
        ,isFilter:false
        ,iconOpen:false//是否显示图标【默认显示】
        ,isOpenDefault:true//节点默认是展开还是折叠【默认展开】
        ,loading:true
        ,method:'post'
        ,isPage:false
        ,cols: [[
            {type:'numbers'}
            ,{field:'id', width:50, title: '分类ID'}
            ,{field:'name', title: '分类名称'}
            ,{field:'route', title: '路由地址'}
            ,{field:'icon', title: '图标'
                ,templet: function(d){
                    var ic='<i class="layui-icon '+d.icon+'"></i>';
                    return ic;
                }
            }
            ,{field:'order', title: '排序'}
            ,{width:200,title: '操作', align:'center'
                ,templet: function(d){
                    var addBtn='<a class="layui-btn layui-btn-xs" lay-event="add">添加</a>';
                    var updateBtn='<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="upt">编辑</a>';
                    var delBtn='<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>';
                    return addBtn+updateBtn+delBtn;
                }
            }
        ]]
        ,parseData:function (res) {//数据加载后回调
            return res;
        }
        ,onClickRow:function (index, o) {
           return;
        }
        ,onDblClickRow:function (index, o) {
           return;
        }
    });

    treeGrid.on('tool('+tableId+')',function (obj) {
        if(obj.event === 'del'){//删除行
            del(obj);
        }else if(obj.event==="add"){//添加行
            add(obj);
        }else if(obj.event==="upt") {//添加行
            upt(obj)
        }
    });



});
/**
 * 更新菜单
 */
function upt(obj) {
    var pdata=obj?obj.data:null;
    if (!pdata.id){
        layer.msg("未找到菜单哦", {icon: 5});
        return false;
    }
    var index = layui.layer.open({
        title : "更新菜单",
        type :2,
        content :menuUpdateUrl+"?menu_id="+pdata.id,
        success : function(layero, index){
            setTimeout(function(){
                layui.layer.tips('点击此处返回菜单列表', '.layui-layer-setwin .layui-layer-close', {
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
function del(obj) {
    layer.confirm("你确定删除数据吗？如果存在下级节点则无法删除！", {icon: 3, title:'提示'},
        function(index){//确定回调

            setTimeout(function(){
                $.post(menuDeleteUrl,{
                    menu_id:obj.data.id,
                },function(res){
                    if (res.status==1){
                        obj.del();
                        location.reload()
                        layer.msg(res.msg, {icon: 1});
                    }else {
                        layer.msg(res.msg, {icon: 5});
                    }
                })
                layer.close(index);
            },1000);
            layer.close(index);
        },function (index) {//取消回调
            layer.close(index);
        }
    );
}


var i=1000000;
//添加
function add(pObj) {
    var pdata=pObj?pObj.data:null;
    var pid=pdata?pdata.id:null;

    var index = layui.layer.open({
        title : "添加菜单",
        type :2,
        content :menuCreateUrl+"?parent_id="+pid,
        success : function(layero, index){
            setTimeout(function(){
                layui.layer.tips('点击此处返回菜单列表', '.layui-layer-setwin .layui-layer-close', {
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
    // param.name='分类'+Math.random();
    // param.id=++i;
    // param.pId=pdata?pdata.id:null;
    // treeGrid.addRow(tableId,pdata?pdata[treeGrid.config.indexName]+1:0,param);
}

function print() {
    console.log(treeGrid.cache[tableId]);
    var loadIndex=layer.msg("对象已打印，按F12，在控制台查看！", {
        time:3000
        ,offset: 'auto'//顶部
        ,shade: 0
    });
}

function openorclose() {
    var map=treeGrid.getDataMap(tableId);
    var o= map['102'];
    treeGrid.treeNodeOpen(tableId,o,!o[treeGrid.config.cols.isOpen]);
}


function openAll() {
    var treedata=treeGrid.getDataTreeList(tableId);
    treeGrid.treeOpenAll(tableId,!treedata[0][treeGrid.config.cols.isOpen]);
}

function getCheckData() {
    var checkStatus = treeGrid.checkStatus(tableId)
        ,data = checkStatus.data;
    layer.alert(JSON.stringify(data));
}
function radioStatus() {
    var data = treeGrid.radioStatus(tableId)
    layer.alert(JSON.stringify(data));
}
function getCheckLength() {
    var checkStatus = treeGrid.checkStatus(tableId)
        ,data = checkStatus.data;
    layer.msg('选中了：'+ data.length + ' 个');
}

function reload() {
    treeGrid.reload(tableId,{
        page:{
            curr:1
        }
    });
}
function query() {
    treeGrid.query(tableId,{
        where:{
            name:'sdfsdfsdf'
        }
    });
}

function test() {
    console.log(treeGrid.cache[tableId],treeGrid.getClass(tableId));


    /*var map=treeGrid.getDataMap(tableId);
    var o= map['102'];
    o.name="更新";
    treeGrid.updateRow(tableId,o);*/
}