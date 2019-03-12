<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-11
 * Time: 下午8:42
 *
 */

use yii\helpers\Url;
?>

<form class="layui-form">
    <blockquote class="layui-elem-quote quoteBox">
        <div class="layui-inline">
            <a class="layui-btn layui-btn-normal assign_btn">添加到可用</a>
        </div>
        <div class="layui-inline">
            <a class="layui-btn layui-btn-warm assignAll_btn">全部添加到可用</a>
        </div>

    </blockquote>
</form>
<table id="assign" lay-filter="assign"></table>
<script>
    const routeAssignUrl="<?=Url::to(['route/assign-route'])?>"
    const routeAvailableListUrl="<?=Url::to(['route/available-list'])?>"
</script>
<?=$this->registerJsFile("@adminPageJs/route/av-index.js")?>
