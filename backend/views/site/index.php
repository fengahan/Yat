<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-11-25
 * Time: 下午4:13
 */
use backend\assets\AppAsset;
use yii\helpers\Url;
use common\core\helper\MenuHelper;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=Yii::$app->name?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="../favicon.ico">
    <?php $this->head() ?>
</head>

<body class="main_body">
<?php $this->beginBody() ?>
<div class="layui-layout layui-layout-admin">
    <!-- 顶部 -->
    <div class="layui-header header">
        <div class="layui-main">
            <a href="#" class="logo" style="font-size:16px;font-weight:600;"><?=Yii::$app->name?></a>
            <!-- 显示/隐藏菜单 -->
            <a href="javascript:;" class="iconfont hideMenu icon-menu1"></a>
            <!-- 搜索 -->

            <!-- 顶部右侧菜单 -->
            <ul class="layui-nav top_menu">
                <li class="layui-nav-item showNotice" id="showNotice" pc>
                    <a href="javascript:;"><i class="iconfont icon-gonggao"></i><cite>系统公告</cite></a>
                </li>
                <li class="layui-nav-item indexHelper" id="indexHelper" pc>
                    <a href="javascript:;" data-url="/pages/helper/helper.html"><i data-icon="&#xe607;" class="layui-icon">&#xe607;</i><cite>常见问题</cite></a>
                </li>
                <li class="layui-nav-item" mobile>
                    <a href="javascript:;" class="mobileAddTab" data-url="/pages/user/userInfo.html">
                        <i class="iconfont icon-zhanghu" data-icon="icon-zhanghu"></i>
                        <cite>个人资料</cite>
                    </a>
                </li>
                <li class="layui-nav-item" mobile>
                    <a href="javascript:;" class="signOut"> <i class="iconfont icon-loginout"></i> 退出</a>
                </li>
                <li class="layui-nav-item lockcms" pc>
                    <a href="javascript:;"><i class="iconfont icon-lock1"></i><cite>锁屏</cite></a>
                </li>
                <li class="layui-nav-item" pc>
                    <a href="javascript:;">
                        <img src="<?=Yii::$app->user->identity->head_img?>" class="layui-circle userIconAs"
                             width="35" height="35">
                        <cite class="userNameAs"><?=Yii::$app->user->identity->nickname?></cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a href="javascript:;" data-url="/pages/user/userInfo.html">
                                <i class="iconfont icon-zhanghu" data-icon="icon-zhanghu"></i>
                                <cite>个人资料</cite>
                            </a>
                        </dd>
                        <dd>
                            <a href="javascript:;" data-url="/pages/user/changePwd.html">
                                <i class="iconfont icon-shezhi1" data-icon="icon-shezhi1"></i>
                                <cite>修改密码</cite>
                            </a>
                        </dd>
                        <dd>
                            <a href="javascript:;" class="changeSkin">
                                <i class="iconfont icon-huanfu"></i>
                                <cite>更换皮肤</cite>
                            </a>
                        </dd>
                        <dd>
                            <a href="javascript:;" class="signOut">
                                <i class="iconfont icon-loginout"></i>
                                <cite>安全退出</cite>
                            </a>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <!-- 左侧导航 -->
    <div class="layui-side layui-bg-black">
        <!-- <div class="user-photo">
            <a class="img" title="我的头像"><img src="/images/face.jpg" class="userIconAs" onerror="javascript:this.src='/images/face.jpg'"></a>
            <p>你好！<strong><span class="userName userNameAs">admin</span></strong>, 欢迎登录</p>
        </div> -->
        <div class="navBar layui-side-scroll"></div>
    </div>
    <!-- 右侧内容 -->
    <div class="layui-body layui-form">
        <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
            <ul class="layui-tab-title top_tab" id="top_tabs">
                <li class="layui-this" lay-id=""><i class="layui-icon">&#xe68e;</i> <cite>主页</cite></li>
            </ul>
            <ul class="layui-nav closeBox">
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="iconfont icon-caozuo"></i> 页面操作</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" class="refresh refreshThis"><i class="layui-icon">&#xe669;</i>
                                刷新当前</a></dd>
                        <dd><a href="javascript:;" class="closePageOther"><i class="iconfont icon-prohibit"></i>
                                关闭其他</a></dd>
                        <dd><a href="javascript:;" class="closePageAll"><i class="iconfont icon-guanbi"></i> 关闭全部</a></dd>
                    </dl>
                </li>
            </ul>
            <div class="layui-tab-content clildFrame">
                <div class="layui-tab-item layui-show">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- 移动导航 -->
<div class="site-tree-mobile layui-hide"><i class="layui-icon">&#xe602;</i></div>
<div class="site-mobile-shade"></div>

<?=$this->registerJsFile("@adminPageJs/site/index.js")?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>