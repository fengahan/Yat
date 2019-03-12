<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-11-25
 * Time: 上午11:03
 *
 */
/* @var $this \yii\web\View */
use backend\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html >
<html lang="<?= Yii::$app->language ?>">

<head>
    <title>登录--<?=Yii::$app->name?></title>
    <meta name="renderer" content="webkit">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="../../favicon.ico">
    <?php $this->registerCssFile('/static/css/layadmin.css')?>
    <?php $this->registerCssFile( '/static/css/laylogin.css')?>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<body class="layui-layout-body" style="background: url('/static/img/login.jpg') no-repeat; background-size: 100% 100%;">
<form class="layui-form" >
    <style>
        .beijtoum {
            background-color: rgba(0, 0, 0, 0.3);
            /* IE9、标准浏览器、IE6和部分IE7内核的浏览器(如QQ浏览器)会读懂 */
        }

        @media \0screen\,screen\9 {
            /* 只支持IE6、7、8 */
            .beijtoum {
                background-color: #000000;
                filter: Alpha(opacity=30);
                position: static;
                /* IE6、7、8只能设置position:static(默认属性) ，否则会导致子元素继承Alpha值 */
                *zoom: 1;
                /* 激活IE6、7的haslayout属性，让它读懂Alpha */
            }

            .beijtoum p {
                position: relative;
                /* 设置子元素为相对定位，可让子元素不继承Alpha值 */
            }
        }

        .layui-form-checkbox[lay-skin=primary] span {
            color: #fff;
        }

        #showPasswordIcon{
            position: absolute;
            right: 1px;
            top: 1px;
            width: 38px;
            line-height: 36px;
            text-align: center;
            color: #d2d2d2;
        }
    </style>
    <div id="LAY_app">
        <div class="layadmin-user-login" id="LAY-user-login" style="display: none;">

            <div class="layadmin-user-login-main">
                <div class="layadmin-user-login-box layadmin-user-login-header">
                    <h2>登录</h2>
                    <p> <?=Yii::$app->name?></p>
                </div>
                <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
                        <input value="fengahan" type="text" name="username" id="username" lay-verify="username"
                               placeholder="账号" class="layui-input">
                    </div>
                    <div class="layui-form-item">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                        <input value="password_0" type="password" name="password" id="password" lay-verify="password"
                               placeholder="密码" class="layui-input">
                        <label id="showPasswordIcon">
                            <i class="layui-icon layui-icon-menu-fill"></i>
                        </label>
                    </div>

                    <div class="layui-form-item" id="imgCode" >
                        <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-captcha"></label>
                        <input value="" type="text" name="captcha" id="LAY-user-login-captcha" lay-verify="required"
                               placeholder="验证码" class="layui-input">
                        <img src="<?=Url::to(["/site/captcha"])?>" data-src="<?=Url::to(["/site/captcha"])?>" id="captcha">
                    </div>


                    <div class="layui-form-item">
                        <button class="layui-btn layui-btn-fluid" id="submitUser" lay-submit="" lay-filter="login"">
                            登 入
                        </button>
                    </div>
                </div>
            </div>

<!--            <div class="layui-trans layadmin-user-login-footer beijtoum">-->
<!--                <p style="color: #fff">&copy; 2019 --><?//=Yii::$app->name?><!--</p>-->
<!--            </div>-->
        </div>
    </div>
</form>
<?=$this->registerJsFile("@adminPageJs/site/login.js")?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
