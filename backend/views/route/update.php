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
            <label class="layui-form-label">路由地址</label>
            <div class="layui-input-block">
                <input type="text" value="<?=$route_info['name']?>" name="name" disabled class="layui-input layui-disabled">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">路由名称</label>
            <div class="layui-input-block">
                <input type="text" value="<?=$route_info['data']['route_name']??''?>" name="data_name" placeholder="请输入路由名称"  class="layui-input ">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">路由描述</label>
            <div class="layui-input-block">
                <input type="text" value="<?=$route_info['data']['route_description']??''?>" name="data_description" placeholder="请输入路由描述"  class="layui-input ">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" value="<?=$route_info['name']?>" name="name" >
                <button class="layui-btn" lay-submit="" lay-filter="updateRoute">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </div>
</form>
<script>
    const routeUpdateUrl="<?=Url::to(['route/update'])?>"
</script>
<?=$this->registerJsFile("@adminPageJs/route/update.js")?>
