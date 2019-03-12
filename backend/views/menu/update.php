<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-15
 * Time: 下午5:48
 */?>
<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-14
 * Time: 下午2:39
 */
use yii\helpers\Url;
?>
<form class="layui-form layui-row lay-filter="create-menuForm">

<div class="layui-col-md6 layui-col-xs12">

    <div class="layui-form-item">
        <label class="layui-form-label">链接地址</label>
        <div class="layui-input-block">
            <input type="text" name="route" id="route-select"  placeholder="请输入链接地址" autocomplete="off" value="<?=$menu_info['route']?>" class="layui-input ">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">菜单名称</label>
        <div class="layui-input-block">
            <input type="text" name="name" placeholder="请输入菜单名称"  lay-verify="required"  value="<?=$menu_info['name']?>" class="layui-input ">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">菜单图标</label>
        <div class="layui-input-block">
            <input type="text" name="icon" placeholder="菜单图标" value="<?=$menu_info_data['icon']??''?>"  id="iconPicker" lay-filter="iconPicker" class="layui-input layui-icon">

        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
            <input type="text" name="order" placeholder="值越大越靠前"  class="layui-input ">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="hidden" name="menu_id" value="<?=$menu_info['id']?>">
            <button class="layui-btn" lay-submit="" lay-filter="createMenu">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</div>
</form>
<script>
    const routeAssignedListUrl="<?=Url::to(['route/assigned-list'])?>"
    const menuUpdateUrl="<?=Url::to(['menu/update'])?>"
</script>

<?=$this->registerJsFile("@adminPageJs/menu/update.js")?>

