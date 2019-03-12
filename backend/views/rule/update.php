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
            <label class="layui-form-label">规则名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" value="<?=$rule_info['name']?>" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">className</label>
            <div class="layui-input-block">
                <input type="text" name="className" placeholder="请输入className" value="<?=$rule_info['className']?>" lay-verify="required" class="layui-input ">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" name="rule_name" value=<?=$rule_info['name']?>>
                <button class="layui-btn" lay-submit="" lay-filter="updateRule">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </div>

</form>
<script>
    const ruleUpdateUrl="<?=Url::to(['rule/update'])?>"
</script>
<?=$this->registerJsFile("@adminPageJs/rule/update.js")?>

