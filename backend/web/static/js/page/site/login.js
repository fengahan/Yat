
pageKeepTop();

$(function () {

    //首次进入页面让第一个文本框获得焦点,这样用户直接回车即可登录。
    $('[name="username"]').focus();


    var showPasswordFun = function () {
        $(this).html('<i class="layui-icon layui-icon-circle"></i>');
        $('[name="password"]').attr('type','text');
    }
    var hidePasswordFun = function () {
        $(this).html('<i class="layui-icon layui-icon-menu-fill"></i>');
        $('[name="password"]').attr('type','password');
    }

    //按住密码框小圆点可显示密码(支持移动端和PC端)
    $('#showPasswordIcon').on("mousedown",showPasswordFun).on('mouseup',hidePasswordFun).on('touchstart',showPasswordFun).on('touchend',hidePasswordFun);

    layui.use(['form', 'layer'], function () {
        var layer = layui.layer;
        var form = layui.form;

        //自定义验证规则
        form.verify({
            username: function (value) {
                if (value.length < 1) {
                    return '请输入账号';
                }
            }
            , password: function (value) {
                if (value.length < 1) {
                    return '请输入密码';
                }
            }
        });

        //登录按钮
        form.on("submit(login)",function(data){
            var username =data.field.username
            var password =data.field.password;
            var captcha  = data.field.captcha;
            var login_url =data.field.action;
            $.ajax({
                type: "POST",
                dataType:'json',
                url:data.form.action,
                data: {"username":username,"password":password,"captcha":captcha},
                success: function(res){
                    if (res.status==1){

                        window.location.href = res.data.url;
                    }else {
                        layer.msg('登录失败...'+res.msg, {icon: 5});
                        changeCatptcha();
                    }

                }
            });

            return false;
        })
        $("#captcha").click(function () {
            changeCatptcha()
        })


    });

/***
* 切换验证码
    */
    function changeCatptcha() {
        var capt = $("#captcha")

        $.ajax({
            type: "GET",
            dataType: 'json',
            url: capt.attr("data-src") + "?refresh=1",
            success: function (res) {
                capt.attr("src", res.url)
            }
        });
    }
    $(document).on("keyup", "input", function (event) {
        if (event.keyCode == 13) {
            $('#submitUser').click();
        }
    });


});
