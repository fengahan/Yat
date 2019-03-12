<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-12-15
 * Time: 下午3:12
 */
use yii\helpers\Url;
?>

<style>
    html, body {
        height: 100%;
        margin:0;padding:0;
        font-size: 12px;
    }
    div{
        -moz-box-sizing: border-box;  /*Firefox3.5+*/
        -webkit-box-sizing: border-box; /*Safari3.2+*/
        -o-box-sizing: border-box; /*Opera9.6*/
        -ms-box-sizing: border-box; /*IE8*/
        box-sizing: border-box; /*W3C标准(IE9+，Safari5.1+,Chrome10.0+,Opera10.6+都符合box-sizing的w3c标准语法)*/
    }
    .dHead {
        height:85px;
        width:100%;
        position: fixed;
        z-index:5;
        top:0;
        overflow-x: auto;
        padding: 10px;
    }
    .dBody {
        width:100%;
        overflow:auto;
        top:90px;
        position:absolute;
        z-index:10;
        bottom:5px;
    }
    .layui-btn-xstree {
        height: 35px;
        line-height: 35px;
        padding: 0px 5px;
        font-size: 12px;
    }
</style>

<div style="height: 100%">
        <form class="layui-form">
            <blockquote class="layui-elem-quote quoteBox">
                <div class="layui-inline">
                    <a class="layui-btn"  onclick="add(null);">新增父菜单</a>
                </div>
                <div class="layui-inline">
                    <a class="layui-btn layui-btn-primary " onclick="openAll();">展开或折叠全部</a>
                </div>
            </blockquote>
        </form>


    <div class="dBody">
        <table class="layui-hidden" id="treeTable" lay-filter="treeTable"></table>
    </div>
</div>
<script>
    const menuCreateUrl="<?=Url::to(['menu/create'])?>";
    const menuUpdateUrl="<?=Url::to(['menu/update'])?>"
    const menuDeleteUrl="<?=Url::to(['menu/delete'])?>"
</script>
<?=$this->registerJsFile("@adminPageJs/menu/index.js")?>
</body>
</html>
