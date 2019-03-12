<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       '/static/plugins/layui/css/layui.css',//这个必须先引入
        '/static/css/public.css',
        '/static/css/main.css',
        '/static/css/index.css',
        '/static/css/font_tnyc012u2rlwstt9.css'

    ];
    public $js = [
        '/static/plugins/layui/layui.js',
        '/static/js/lay-sys/layui.util.js',
        '/static/js/lay-sys/javascript.util.js',
        '/static/js/lay-sys/jquery.util.js',
        '/static/plugins/jquery.min.js',

    ];

}
