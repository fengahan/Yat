
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
            <a class="layui-btn addNewAdminUser_btn">添加管理员</a>
        </div>
    </blockquote>
</form>
<table id="adminUser" lay-filter="adminUser"></table>
<!--操作-->
<script type="text/html" id="adminUserListBar">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="update">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
</script>
<script type="text/html" id="statusTpl">
    <input type="checkbox" name="状态" value="{{d.id}}" lay-skin="switch" lay-text="正常|锁定" lay-filter="statusSwitch" {{ d.status ==10 ? 'checked' : '' }}>
</script>
<script>
    const adminUserList="<?=Url::to(['admin-user/list'])?>";
    const adminUserDeleteUrl="<?=Url::to(['admin-user/delete'])?>";
    const adminUserUpdateUrl="<?=Url::to(['admin-user/update'])?>";
    const adminUserUpdateStatusUrl="<?=Url::to(['admin-user/update-status'])?>";
    const adminUserCreateUrl="<?=Url::to(['admin-user/create'])?>";
</script>
<?=$this->registerJsFile("@adminPageJs/admin-user/index.js")?>

