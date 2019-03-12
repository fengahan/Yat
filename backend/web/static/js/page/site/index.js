var bodyTab;

$(function () {

    //config的设置是全局的
    layui.config({
        base: '/static/plugins/layui-extend/' //这是你存放拓展模块的根目录
    }).use(['bodyTab', 'form', 'colorpicker'], function () {

        var colorpicker = layui.colorpicker;
        var element = layui.element;
        var form = layui.form;
        var layer = layui.layer;
        bodyTab = layui.bodyTab;

        bodyTab.set({
            openTabNum: "50",  //最大可打开窗口数量
            tabFilter: "bodyTab",  //layui的element模块事件过滤器
            ajaxSettings: {  //ajax参数，与jquery.ajax一致
                url: "/site/left-nav",
                type: 'get'
            }
        });

        skins();
        //更换皮肤
        $(".changeSkin").click(function () {
            layer.open({
                title: "更换皮肤",
                area: ["450px", "210px"],
                type: "1",
                content: '<div class="skins_box">' +
                '<form class="layui-form">' +
                '<div class="layui-form-item">' +
                '<input type="radio" name="skin" value="默认" title="默认" lay-filter="default" checked="">' +
                '<input type="radio" name="skin" value="橙色" title="橙色" lay-filter="orange">' +
                '<input type="radio" name="skin" value="蓝色" title="蓝色" lay-filter="blue">' +
                '<input type="radio" name="skin" value="自定义" title="自定义" lay-filter="custom">' +
                '<div class="skinCustom">' +
                '<input type="text" class="layui-input topColor" name="topSkin" placeholder="顶部颜色" /><span id="topSkin-form" ></span>' +
                '<input type="text" class="layui-input leftColor" name="leftSkin" placeholder="左侧颜色" /><span id="leftSkin-form" ></span>' +
                '<input type="text" class="layui-input menuColor layui-hide" name="btnSkin" placeholder="顶部菜单按钮" /><span id="btnSkin-form" ></span>' +
                '</div>' +
                '</div>' +
                '<div class="layui-form-item skinBtn">' +
                '<a href="javascript:void(0)" class="layui-btn layui-btn-small layui-btn-normal" lay-submit="" lay-filter="changeSkin">确定更换</a>' +
                '<a href="javascript:void(0)" class="layui-btn layui-btn-small layui-btn-primary" lay-submit="" lay-filter="noChangeSkin">我再想想</a>' +
                '</div>' +
                '</form>' +
                '</div>',
                success: function (index, layero) {

                    colorpicker.render({
                        elem: '#topSkin-form'
                        , color: '#000'
                        , done: function (color) {
                            $('.topColor,.menuColor').val(color);
                            $('.topColor,.menuColor').blur();
                        }
                        , alpha: true
                        , predefine: true
                    });

                    colorpicker.render({
                        elem: '#leftSkin-form'
                        , color: '#000'
                        , done: function (color) {
                            $('.leftColor').val(color);
                            $('.leftColor').blur();
                        }
                        , alpha: true
                        , predefine: true
                    });


                    var skin = window.localStorage.getItem("skin");
                    if (window.localStorage.getItem("skinValue")) {
                        $(".skins_box input[value=" + window.localStorage.getItem("skinValue") + "]").attr("checked", "checked");
                    };
                    if ($(".skins_box input[value=自定义]").attr("checked")) {
                        $(".skinCustom").css("visibility", "inherit");
                        $(".topColor").val(skin.split(',')[0]);
                        $(".leftColor").val(skin.split(',')[1]);
                        $(".menuColor").val(skin.split(',')[2]);
                    };
                    form.render();
                    $(".skins_box").removeClass("layui-hide");
                    $(".skins_box .layui-form-radio").on("click", function () {
                        var skinColor;
                        if ($(this).find("div").text() == "橙色") {
                            skinColor = "orange";
                        } else if ($(this).find("div").text() == "蓝色") {
                            skinColor = "blue";
                        } else if ($(this).find("div").text() == "默认") {
                            skinColor = "";
                        }
                        if ($(this).find("div").text() != "自定义") {
                            $(".topColor,.leftColor,.menuColor").val('');
                            $("body").removeAttr("class").addClass("main_body " + skinColor + "");
                            $(".skinCustom").removeAttr("style");
                            $(".layui-bg-black,.hideMenu,.layui-layout-admin .layui-header").removeAttr("style");
                        } else {
                            $(".skinCustom").css("visibility", "inherit");
                        }
                    })
                    var skinStr, skinColor;
                    $(".topColor").focus(function () {
                        layer.open({
                            type: 4,
                            content: ['请输入[十六进制颜色码]或者颜色的[英文单词]', this]
                            , shade: 0
                            , closeBtn: 0
                            , time: 5000
                        });
                    }).blur(function () {
                        layer.closeAll('tips');
                        $(".layui-layout-admin .layui-header").css("cssText", "background-color:" + $(this).val() + " !important");
                        $(".hideMenu").css("cssText", "background-color:" + $(this).val() + " !important");
                    });
                    $(".leftColor").focus(function () {
                        layer.open({
                            type: 4,
                            content: ['请输入[十六进制颜色码]或者颜色的[英文单词]', this]
                            , shade: 0
                            , closeBtn: 0
                            , time: 5000
                        });
                    }).blur(function () {
                        layer.closeAll('tips');
                        $(".layui-bg-black").css("cssText", "background-color:" + $(this).val() + " !important");
                    });

                    form.on("submit(changeSkin)", function (data) {
                        if (data.field.skin != "自定义") {
                            if (data.field.skin == "橙色") {
                                skinColor = "orange";
                            } else if (data.field.skin == "蓝色") {
                                skinColor = "blue";
                            } else if (data.field.skin == "默认") {
                                skinColor = "";
                            }
                            window.localStorage.setItem("skin", skinColor);
                        } else {
                            skinStr = $(".topColor").val() + ',' + $(".leftColor").val() + ',' + $(".menuColor").val();
                            window.localStorage.setItem("skin", skinStr);
                            $("body").removeAttr("class").addClass("main_body");
                        }
                        window.localStorage.setItem("skinValue", data.field.skin);
                        layer.closeAll("page");
                    });
                    form.on("submit(noChangeSkin)", function () {
                        $("body").removeAttr("class").addClass("main_body " + window.localStorage.getItem("skin") + "");
                        $(".layui-bg-black,.hideMenu,.layui-layout-admin .layui-header").removeAttr("style");
                        skins();
                        layer.closeAll("page");
                    });
                },
                cancel: function () {
                    $("body").removeAttr("class").addClass("main_body " + window.localStorage.getItem("skin") + "");
                    $(".layui-bg-black,.hideMenu,.layui-layout-admin .layui-header").removeAttr("style");
                    skins();
                }
            })
        });

        //退出
        $(".signOut").click(function (event) {
            layer.confirm('确定退出登录？',{icon:3, title:'提示信息'},function(){
                $.ajax({
                    type: "POST",
                    url:'/site/logout',
                    success: function(res){
                        if (res.status==1){
                            window.location.href = res.data.url;
                        }else {
                            layer.msg('无法正确退出...'+res.msg, {icon: 5});
                        }
                    }
                });
            });
        });

        //隐藏左侧导航
        $(".hideMenu").click(function () {
            $(".layui-layout-admin").toggleClass("showMenu");
            //渲染顶部窗口
            bodyTab.tabMove();
            //layer.msg("如果页面显示不正常可在右方的页面操作里点击刷新当前页哦~", { time: 900 });
        });

        // 解锁
        $(document).on("click", "#unlock", function () {

            var thisEle = this;

            if ($(thisEle).siblings(".admin-header-lock-input").val() == '') {
                layer.msg("请输入解锁密码！", { anim: 10, icon: 0, zIndex: 19991014 });
                $(thisEle).siblings(".admin-header-lock-input").focus();
            } else {
                var user = {
                    userAcc: $('#lockUserName').text(),
                    passwd: $(thisEle).siblings(".admin-header-lock-input").val()
                }

                $(thisEle).addClass("layui-btn-disabled").prop("disabled", true).text("解锁中…");


                setTimeout(function () {

                    if (user.userAcc === 'admin' && user.passwd === '123') {

                        window.localStorage.setItem("lockcms", false);
                        $(thisEle).siblings(".admin-header-lock-input").val('');
                        layer.closeAll("page");
                        layer.msg("解锁成功.", { anim: 10, icon: 1, zIndex: 19991014 });
                        //如果没有菜单则刷新
                        if ($('.navBar').html() == '') {
                            //从缓存取页面刷新
                            window.location.reload(false);
                            //从服务器重新取页面刷新
                            window.location.reload(true);
                            //跳转式刷新
                            window.location.href = window.location.href;
                        }

                    } else {
                        layer.msg('解锁失败,请检查密码是否正确。', { anim: 10, icon: 0, zIndex: 19991014 });
                        $(thisEle).siblings(".admin-header-lock-input").val('').focus();
                    }

                    $(thisEle).removeClass("layui-btn-disabled").prop("disabled", false).text("解锁");

                }, "1000");

            }
        });

        //锁屏
        $(".lockcms").on("click", function () {
            window.localStorage.setItem("lockcms", true);
            lockPage();
        });

        //锁屏页面回车
        $(document).on('keydown', function (event) {
            if (event.keyCode == 13) {
                $("#unlock").click();
            }
        });

        // 判断是否显示锁屏
        if (window.localStorage.getItem("lockcms") == "true") {
            lockPage();
        }

        //弹出公告
        $(".showNotice").on("click", function () {
            showNotice();
        });

        //手机设备的简单适配
        $('.site-tree-mobile').on('click', function () {
            $('body').addClass('site-mobile');
        });
        $('.site-mobile-shade').on('click', function () {
            $('body').removeClass('site-mobile');
        });

        //刷新当前
        $(".refresh").on("click", function () {
            //获取当前打开的元素
            var showElement = $(".clildFrame .layui-tab-item.layui-show").find("iframe")[0];
            //手动设置一下src刷新
            showElement.src = showElement.src;
            //从缓存取页面刷新
            showElement.contentWindow.location.reload(false);
            //从服务器重新取页面刷新
            showElement.contentWindow.location.reload(true);
            //跳转式刷新
            showElement.contentWindow.location.href = showElement.src;
        });

        //监听切换tab设置当前选中tab
        $(document).on("click", ".top_tab li", function () {
            bodyTab.monitorSwitchTab(this);
        });

        //删除tab，tab关闭 监听
        $(document).on("click", ".top_tab li i.layui-tab-close", function () {
            bodyTab.monitorCloseTab(this);
        });

        // 添加新窗口
        $(document).on("click", ".layui-nav .layui-nav-item a", function (event) {
            event.preventDefault();
            //如果不存在子级
            if ($(this).siblings().length == 0) {
                addTab($(this));
                $('body').removeClass('site-mobile');  //移动端点击菜单关闭菜单层
            }
            $(this).parent("li").siblings().removeClass("layui-nav-itemed");
        });

        //双击时刷新当前窗口
        $(document).on("dblclick", ".layui-nav .layui-nav-item a", function (event) {
            event.preventDefault();
            //如果不存在子级
            if ($(this).siblings().length == 0) {
                $(".refresh")[0].click();
            }
        });

        //刷新后还原打开的窗口
        if (window.sessionStorage.getItem("menu")) {
            bodyTab.refreshRestoreTab();
        }

        //判断是否是刷新来的tab，是的话刷新当前页面
        element.on('tab(bodyTab)', function (data) {
            var notNewTabEle = $(this).find("[layuiTabTypeOpen='notNewTab']");
            if (notNewTabEle[0] != undefined) {
                notNewTabEle.removeAttr('layuiTabTypeOpen');
                $(".refresh")[0].click();
            }

            //切换tab时选中左侧菜单
            bodyTab.selectedMenu($(this).find('cite').html());
        });

        //关闭其他
        $(".closePageOther").on("click", function () {
            bodyTab.CloseOtherTab();
        });
        //关闭全部
        $(".closePageAll").on("click", function () {
            bodyTab.CloseAllTab();
        });

    });//layui.use的结尾

});//jquery的结尾

//更换皮肤
function skins() {
    var skin = window.localStorage.getItem("skin");
    if (skin) {  //如果更换过皮肤
        if (window.localStorage.getItem("skinValue") != "自定义") {
            $("body").addClass(window.localStorage.getItem("skin"));
        } else {
            $(".layui-layout-admin .layui-header").css("cssText", "background-color:" + skin.split(',')[0] + " !important");
            $(".layui-bg-black").css("cssText", "background-color:" + skin.split(',')[1] + " !important");
            $(".hideMenu").css("cssText", "background-color:" + skin.split(',')[2] + " !important");
        }
    }
}

//锁屏
function lockPage() {
    top.layer.closeAll();
    layer.closeAll();
    top.layer.open({
        title: false,
        type: 1,
        content: '	<div class="admin-header-lock" id="lock-box">' +
        '<div class="admin-header-lock-img"><img src="' + localStorage.getItem("userIconAs") + '"  onerror="javascript:this.src=\'/images/face.jpg\'" /></div>' +
        '<div class="admin-header-lock-name" id="lockUserName">' + (localStorage.getItem("userNameAs") || 'admin') + '</div>' +
        '<div class="input_btn">' +
        '<input type="password" class="admin-header-lock-input layui-input" autocomplete="off" placeholder="请输入密码解锁.." name="lockPwd" id="lockPwd" />' +
        '<button class="layui-btn layui-btn-normal" style="width: 80px;" id="unlock">解锁</button>' +
        '</div>' +
        '<p>页面已锁定,请输入登陆密码解锁.</p>' +
        '</div>',
        closeBtn: 0,
        shade: 0.9,
        zIndex: 19891020
    })
}


//公告层
function showNotice() {
    layer.open({
        type: 1,
        title: "系统公告",
        closeBtn: false,
        area: '310px',
        shade: 0.8,
        id: 'LAY_layuipro',
        btn: ['我知道了'],
        moveType: 1,
        content: '<div style="padding:15px 20px; text-align:justify; line-height: 22px; text-indent:2em;border-bottom:1px solid #e2e2e2;"><p>基于Yii2+layui开发的一套后台框架。致力于简洁代码和拿来即用。欢迎在<a href="https://github.com/fengahan/Yat" target="_blank">Github</a>Issues中提建议和bug。</p><p>非常感谢马哥的<a href="https://gitee.com/layuicms/layuicms" target="_blank">layuicms</a>，我的成长从他那里开始。</p></div>',
        success: function (layero) {
            var btn = layero.find('.layui-layer-btn');
            btn.css('text-align', 'center');
            btn.on("click", function () {
                window.sessionStorage.setItem("showNotice", "true");
            });
        },
        yes: function (index, layero) {
            layer.close(index);
            if ($(window).width() > 432) {  //如果页面宽度不足以显示顶部“系统公告”按钮，则不提示

                layer.tips('系统公告躲在了这里', '#showNotice', {
                    tips: 3
                });

            }
        }
    });
}

//打开新窗口
function addTab(_this) {
    bodyTab.tabAdd(_this);
}


/**
 * 打开新tab
 * @param {string} url 要打开的地址
 * @param {string} title 显示的标题
 * @param {string} icon 显示的图标
 */
function addTabByUrlTitleIcon(url, title, icon) {
    var html = '<i data-url="' + url + '" ><cite>' + title + '</cite><i class="layui-icon" data-icon="' + icon + '"></i></i>';
    bodyTab.tabAdd($(html));
}