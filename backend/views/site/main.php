<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-11-25
 * Time: 下午4:47
 */?>
<blockquote class="layui-elem-quote layui-bg-green">
    <div id="nowTime">你好管理员 欢迎登录</div>
</blockquote>
<div class="layui-row layui-col-space10 panel_box">
    <div class="panel layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
        <a href="javascript:;" data-url="http://fly.layui.com/case/u/3198216" target="_blank">
            <div class="panel_icon layui-bg-green">
                <i class="layui-anim seraph icon-good"></i>
            </div>
            <div class="panel_word">
                <span>为我点赞</span>
                <cite>点赞地址链接</cite>
            </div>
        </a>
    </div>
    <div class="panel layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
        <a href="javascript:;" data-url="#" target="_blank">
            <div class="panel_icon layui-bg-black">
                <i class="layui-anim seraph icon-github"></i>
            </div>
            <div class="panel_word">
                <span>Github</span>
                <cite>模版下载链接</cite>
            </div>
        </a>
    </div>
    <div class="panel layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
        <a href="javascript:;" data-url="#" target="_blank">
            <div class="panel_icon layui-bg-red">
                <i class="layui-anim seraph icon-oschina"></i>
            </div>
            <div class="panel_word">
                <span>码云</span>
                <cite>模版下载链接</cite>
            </div>
        </a>
    </div>
    <div class="panel layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
        <a href="javascript:;" data-url="#">
            <div class="panel_icon layui-bg-orange">
                <i class="layui-anim seraph icon-icon10" data-icon="icon-icon10"></i>
            </div>
            <div class="panel_word userAll">
                <span>100</span>
                <em>用户总数</em>
                <cite class="layui-hide">用户中心</cite>
            </div>
        </a>
    </div>
    <div class="panel layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
        <a href="javascript:;" data-url="page/systemSetting/icons.html">
            <div class="panel_icon layui-bg-cyan">
                <i class="layui-anim layui-icon" data-icon="&#xe857;">&#xe857;</i>
            </div>
            <div class="panel_word outIcons">
                <span></span>
                <em>外部图标</em>
                <cite class="layui-hide">图标管理</cite>
            </div>
        </a>
    </div>
    <div class="panel layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg2">
        <a href="javascript:;">
            <div class="panel_icon layui-bg-blue">
                <i class="layui-anim seraph icon-clock"></i>
            </div>
            <div class="panel_word">
                <span class="loginTime"></span>
                <cite>上次登录时间</cite>
            </div>
        </a>
    </div>
</div>
<blockquote class="layui-elem-quote main_btn">
    <p>本模板基于Layui2.*实现，支持除LayIM外所有的Layui组件。<a href="http://layim.layui.com/#getAuth" target="_blank" class="layui-btn layui-btn-xs">获取LayIM授权</a>　layui开发文档地址：<a class="layui-btn layui-btn-xs layui-btn-danger" target="_blank" href="http://www.layui.com/doc">layui文档</a></p>
    <p class="layui-red">郑重提示：本模版作为学习交流免费使用【强烈要求付费或者捐赠的我也就默默的接受了😄】，如需用作商业用途，请联系作者购买【本模版已进行作品版权证明，不管以何种形式获取的源码，请勿进行出售或者上传到任何素材网站，否则将追究相应的责任】</p>
    <p>注：本模版未引入任何第三方组件，单纯的layui+js实现的各种功能。网站所有数据均为静态数据，无数据库，除打开的窗口和部分小改动外所有操作刷新后无效，关闭窗口或清除缓存后，所有操作无效，请知悉。</p>
    <p class="layui-blue">PS：这只是模版而不是定制开发，不能覆盖升级很正常，请不要因为不能覆盖升级来喷我，我表示很无辜，谢谢大家</p>
</blockquote>
<div class="layui-row layui-col-space10">
    <div class="layui-col-lg12 layui-col-md12">
        <blockquote class="layui-elem-quote title">系统基本参数</blockquote>
        <table class="layui-table magt0">
            <colgroup>
                <col width="150">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <td>当前版本</td>
                <td class="version"></td>
            </tr>
            <tr>
                <td>开发作者</td>
                <td class="author"></td>
            </tr>
            <tr>
                <td>网站首页</td>
                <td class="homePage"></td>
            </tr>
            <tr>
                <td>服务器环境</td>
                <td class="server"></td>
            </tr>
            <tr>
                <td>数据库版本</td>
                <td class="dataBase"></td>
            </tr>
            <tr>
                <td>最大上传限制</td>
                <td class="maxUpload"></td>
            </tr>
            <tr>
                <td>当前用户权限</td>
                <td class="userRights"></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<?=$this->registerJsFile("@adminPageJs/site/main.js")?>
