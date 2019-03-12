
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
            <a class="layui-btn addNewRole_btn">添加角色</a>
        </div>
    </blockquote>
</form>
<table id="role" lay-filter="role"></table>
<!--操作-->
<script type="text/html" id="roleListBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="update">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
    <a class="layui-btn layui-btn-xs" lay-event="view">查看</a>


</script>
<script>
    const roleListUrl="<?=Url::to(['role/list'])?>";
    const roleDeleteUrl="<?=Url::to(['role/delete'])?>";
    const roleUpdateUrl="<?=Url::to(['role/update'])?>";
    const roleCreateUrl="<?=Url::to(['role/create'])?>";
    const roleViewUrl="<?=Url::to(['role/view'])?>";
</script>
<?=$this->registerJsFile("@adminPageJs/role/index.js")?>

