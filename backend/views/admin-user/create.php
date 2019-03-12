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

/**
 * @var $this \yii\web\View;
 */
use yii\helpers\Url;
?>

<form class="layui-form layui-row">

    <div class="layui-col-md6 layui-col-xs12">

        <div class="layui-form-item">
            <label class="layui-form-label">登录帐号</label>
            <div class="layui-input-block">
                <input type="text" name="username" lay-verify="required" placeholder="请输入登录帐号" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-block">
                <input type="text" name="nickname" lay-verify="required" placeholder="请输入真实姓名" class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色及权限</label>
            <div class="layui-input-block">

                <select name="items" xm-select="selectItems">
                    <?php foreach ($assignData as $key=>$value):?>
                    <optgroup label="<?=$key=='role'?'角色':'权限'?>">
                        <?php foreach ($value as $k=>$val):?>
                            <option value="<?=$val?>"><?=$val?></option>
                        <?php endforeach;?>
                    </optgroup>
                    <?php endforeach;?>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">头像</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn" id="uploadHead">上传图片</button>
                    <input class="layui-upload-file" type="file" accept="undefined" name="file">
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="headSrcView">
                        <p id="uploadHeadText"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
                <input type="text" name="email" placeholder="请输入邮箱" lay-verify="email" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="password" name="password" placeholder="请输入登录密码" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" name="head_img" value="" id="headSrc">
                <button class="layui-btn" lay-submit="" lay-filter="createAdminUser">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </div>
</form>
<script>
    const adminUserCreateUrl="<?=Url::to(['admin-user/create'])?>"
</script>
<?=$this->registerJsFile("@adminPageJs/admin-user/create.js")?>
<?=$this->registerCssFile("@adminExtCss/layuiformSelects/dist/formSelects-v4.css")?>
