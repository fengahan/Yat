<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<style>
    body {
        padding: 5% 0 0 0;
        margin: 0;
        text-align: center;
        overflow: hidden;
    }
</style>
<body>
<i class="layui-icon layui-anim layui-anim-up"
   style="line-height:20rem; font-size:20rem; color: #393D50;">&#xe61c;</i>
<p class="layui-anim layui-anim-scaleSpring" style="font-size: 20px; font-weight: 300; color: #999;">
    <?= nl2br(Html::encode($message)) ?>
</p>
</body>