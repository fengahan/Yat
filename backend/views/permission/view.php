<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-24
 * Time: 下午3:24
 */
use yii\helpers\Url;
?>
<div class="layui-form layui-row">
        <div class="layui-fluid">
            <blockquote class="layui-elem-quote">
                分配权限到:<?=$per_info['name']?>
            </blockquote>
            <blockquote class="layui-elem-quote layui-quote-nm">
                权限描述:  <?=$per_info['description']?>
            </blockquote>

            <div class="layui-row layui-col-space10">
                <div class="layui-col-md5">
                    <table class="layui-hide" id="left_tab" lay-filter="left"></table>
                </div>
                <div class="layui-col-md2 btn-height">
                    <div style="margin-bottom: 10px;">
                        <button class="layui-btn  layui-btn-disabled left-btn">
                            <i class="layui-icon layui-icon-forward"></i>
                        </button>
                    </div>
                    <div >
                        <button class="layui-btn layui-btn-disabled right-btn">
                            <i class="layui-icon layui-icon-back"></i>
                        </button>
                    </div>
                </div>
                <div class="layui-col-md5">
                    <table class="layui-hide" id="right_tab" lay-filter="right"></table>
                </div>
            </div>
        </div>
</div>
<script>
    const per_name='<?=$per_info['name']?>';
    const permissionAllUrl='<?=Url::to(['permission/permission-all'])?>';
    const permissionAssUrl='<?=Url::to(['permission/permission-ass'])?>';
    const permissionAssignUrl='<?=Url::to(['permission/assign'])?>';
    const permissionRemoveUrl='<?=Url::to(['permission/remove'])?>';
</script>
<?=$this->registerJsFile("@adminPageJs/permission/view.js")?>