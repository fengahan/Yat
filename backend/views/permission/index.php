
<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-22
 * Time: 下午11:43
 */

use yii\helpers\Url;
?>

<form class="layui-form">
    <blockquote class="layui-elem-quote quoteBox">
        <div class="layui-inline">
            <a class="layui-btn addNewPer_btn">添加权限</a>
        </div>
    </blockquote>
</form>
<table id="permission" lay-filter="permission"></table>
<!--操作-->
<script type="text/html" id="permissionListBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="update">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
    <a class="layui-btn layui-btn-xs" lay-event="view">查看</a>
</script>
<script>
    const permissionListUrl="<?=Url::to(['permission/list'])?>";
    const permissionDeleteUrl="<?=Url::to(['permission/delete'])?>";
    const permissionUpdateUrl="<?=Url::to(['permission/update'])?>";
    const permissionCreateUrl="<?=Url::to(['permission/create'])?>";
    const permissionViewUrl="<?=Url::to(['permission/view'])?>";
</script>
<?=$this->registerJsFile("@adminPageJs/permission/index.js")?>

