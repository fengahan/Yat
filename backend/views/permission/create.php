<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-23
 * Time: 下午4:23
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
<form class="layui-form layui-row">

    <div class="layui-col-md6 layui-col-xs12">

        <div class="layui-form-item">
            <label class="layui-form-label">权限名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-block">
                <input type="text" name="description" placeholder="请输入描述"  class="layui-input ">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">规则名称</label>
            <div class="layui-input-block">
                <input type="text" name="ruleName" id="rule-name-select"  placeholder="请选择规则名称"  autocomplete="off"  class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">扩展数据</label>
            <div class="layui-input-block">
                <input type="text" name="data" placeholder="请输入扩展数据"  class="layui-input ">
            </div>
        </div>


        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="createPermission">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </div>
</form>
<script>
    const permissionCreateUrl="<?=Url::to(['permission/create'])?>"
    const ruleListUrl="<?=Url::to(['rule/list'])?>";

</script>
<?=$this->registerJsFile("@adminPageJs/permission/create.js")?>

