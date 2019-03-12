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
            <label class="layui-form-label">登录帐号</label>
            <div class="layui-input-block">
                <input type="text" name="username" lay-verify="required" placeholder="请输入登录帐号" value="<?=$admin_user['username']?>" disabled class="layui-input layui-disabled">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-block">
                <input type="text" name="nickname" lay-verify="required" placeholder="请输入真实姓名" value="<?=$admin_user['nickname']?>" class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色及权限</label>
            <div class="layui-input-block">

                <select name="items" xm-select="selectItems">
                    <?php foreach ($all_role as $key=>$value):?>
                        <optgroup label="<?=$key=='role'?'角色':'权限'?>">
                            <?php foreach ($value as $k=>$val):?>
                                <?php $ass=$assignData[$key]??[];?>
                                <?php if (in_array($val,$ass)):?>
                                <option value="<?=$val?>" selected="selected"><?=$val?></option>
                                <?php else:?>
                                   <option value="<?=$val?>"><?=$val?></option>
                                <?php endif;?>

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
                        <img class="layui-upload-img" id="headSrcView" src="<?=$admin_user['head_img']??"https://www.yiichina.com/uploads/avatar/000/02/90/86_avatar_small.jpg"?>">
                        <p id="uploadHeadText"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
                <input type="text" name="email" placeholder="请输入邮箱" lay-verify="email" value="<?=$admin_user['email']?>" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="password" name="password" placeholder="请输入登录密码" class="layui-input">
            </div>
        </div>
        <?php if ($admin_user['role']==\backend\models\AdminUser::ROLE_MANAGEMENT):?>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block ">
                <input type="radio" name="status" value="10" title="可用" <?=$admin_user['status']==10?'checked="checked"':''?>><div class="layui-unselect layui-form-radio"><div>可用</div></div>
                <input type="radio" name="status" value="0" title="不可用" <?=$admin_user['status']==0?'checked="checked"':''?>><div class="layui-unselect layui-form-radio"><div>不可用</div></div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">等级</label>
            <div class="layui-input-block ">
                <input type="radio" name="role" value="10" title="Root"  <?=$admin_user['role']==10?'checked="checked"':''?>><div class="layui-unselect layui-form-radio"><div>ROOT</div></div>
                <input type="radio" name="role" value="30" title="管理员"  <?=$admin_user['role']==30?'checked="checked"':''?>><div class="layui-unselect layui-form-radio"><div>管理员</div></div>
            </div>
        </div>
        <?php endif;?>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" name="head_img" value="" id="headSrc">
                <input type="hidden" name="admin_user_id" value="<?=$admin_user['id']?>">
                <button class="layui-btn" lay-submit="" lay-filter="updateAdminUser">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </div>
</form>
<script>
    const adminUserUpdateUrl="<?=Url::to(['admin-user/update'])?>"
</script>
<?=$this->registerJsFile("@adminPageJs/admin-user/update.js")?>
<?=$this->registerCssFile("@adminExtCss/layuiformSelects/dist/formSelects-v4.css")?>