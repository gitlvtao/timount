<?php /*a:1:{s:55:"D:\Timount\mall\application\admin\view\login\index.html";i:1539228170;}*/ ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录 - 天芒云</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="/static/layuiadmin/layui/css/layui.css" /><link rel="stylesheet" type="text/css" href="/static/layuiadmin/style/admin.css" /><link rel="stylesheet" type="text/css" href="/static/layuiadmin/style/login.css" />
</head>
<body>

<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

    <div class="layadmin-user-login-main">
        <div class="layadmin-user-login-box layadmin-user-login-header">
            <h2>Timount</h2>
            <p>技术部通用后台管理模板系统</p>
        </div>
        <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="login-username"></label>
                <input type="text" name="username" id="login-username" lay-verify="required" placeholder="用户名" class="layui-input">
            </div>
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="login-password"></label>
                <input type="password" name="password" id="login-password" lay-verify="required" placeholder="密码" class="layui-input">
            </div>
            <div class="layui-form-item">
                <div class="layui-row">
                    <div class="layui-col-xs7">
                        <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="login-vercode"></label>
                        <input type="text" name="vercode" id="login-vercode" lay-verify="required" placeholder="图形验证码" class="layui-input">
                    </div>
                    <div class="layui-col-xs5">
                        <div style="margin-left: 10px;">
                            <img src="" alt="captcha" id="randomCodeImg" class="layadmin-user-login-codeimg" onclick="javascript:refreshVercode();" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-form-item" style="margin-bottom: 20px;">
                <input type="checkbox" name="remember" lay-skin="primary" title="记住密码">
                <a href="forget.html" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">忘记密码？</a>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="login-submit">登 入</button>
            </div>
            <!--<div class="layui-trans layui-form-item layadmin-user-login-other">
                <label>社交账号登入</label>
                <a href="javascript:;"><i class="layui-icon layui-icon-login-qq"></i></a>
                <a href="javascript:;"><i class="layui-icon layui-icon-login-wechat"></i></a>
                <a href="javascript:;"><i class="layui-icon layui-icon-login-weibo"></i></a>

                <a href="reg.html" class="layadmin-user-jump-change layadmin-link">注册帐号</a>
            </div>-->
        </div>
    </div>

    <div class="layui-trans layadmin-user-login-footer">

        <p>© 2018 <a href="http://www.timount.com/" target="_blank">timount.com</a></p>
        <p>
            武汉天芒云信息技术有限公司
        </p>
    </div>

    <!--<div class="ladmin-user-login-theme">
      <script type="text/html" template>
        <ul>
          <li data-theme=""><img src="{{ layui.setter.base }}style/res/bg-none.jpg"></li>
          <li data-theme="#03152A" style="background-color: #03152A;"></li>
          <li data-theme="#2E241B" style="background-color: #2E241B;"></li>
          <li data-theme="#50314F" style="background-color: #50314F;"></li>
          <li data-theme="#344058" style="background-color: #344058;"></li>
          <li data-theme="#20222A" style="background-color: #20222A;"></li>
        </ul>
      </script>
    </div>-->

</div>

<script type="text/javascript" src="/static/layuiadmin/layui/layui.js"></script>
<script>
    //保证当前窗口是在最前面
    if (window != top) {
        top.location.href = window.location.href;
    }
    layui.config({
        base: '/static/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'user'], function(){
        var $ = layui.$
            ,setter = layui.setter
            ,admin = layui.admin
            ,form = layui.form
            ,router = layui.router()
            ,search = router.search;

        form.render();

        //提交
        form.on('submit(login-submit)', function(obj){
            var username = $("input[name='username']").val();
            var password = $("input[name='password']").val();
            var vercode = $("input[name='vercode']").val();
            layer.load(1); //显示加载圈
            $.post("<?php echo url('admin/login/index'); ?>", {
                username : username,
                password : password,
                vercode: vercode
            }, function(result) {
                if (result.code == 0) {
                    location.href = "<?php echo url('admin/index/index'); ?>"; //进入管理后台
                } else {
                    layer.closeAll('loading');
                    layer.alert(result.msg, {icon: 2});
                    refreshVercode();
                }
            }, "json");

        });
    });

    // 刷新验证码
    function refreshVercode(){
        document.getElementById("randomCodeImg").src = "<?php echo url('admin/login/vercode'); ?>?r=" + Math.random();
    }
    refreshVercode();
</script>
</body>
</html>