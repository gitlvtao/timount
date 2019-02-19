<?php /*a:1:{s:59:"D:\Timount\mall\application\admin\view\adminuser\index.html";i:1539228170;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <!-- 下面是定义标签库 -->
    <!-- 下面是定义通用的meta头信息 -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <link rel="stylesheet" type="text/css" href="/static/layuiadmin/layui/css/layui.css" /><link rel="stylesheet" type="text/css" href="/static/layuiadmin/style/admin.css" />
    <title></title>
</head>
<body>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <form class="layui-form" id="search-form">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">用户名称</label>
                        <div class="layui-input-inline">
                            <input type="text" name="nickname" placeholder="模糊搜索" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">登录账号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="username" placeholder="模糊搜索" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">用户状态</label>
                        <div class="layui-input-inline">
                            <select name="status">
                                <option value="">请选择</option>
                                <option value="1">正常</option>
                                <option value="0">冻结</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-sm" lay-submit lay-filter="layui-datatables-search">搜索</button>
                        <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary" lay-submit lay-filter="layui-datatables-reset">重置</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- datatables页 -->
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layui-btn-sm" id="btn-add">新增管理员</button>
            </div>
            <table id="layui-datatables" lay-filter="layui-datatables"></table>
        </div>
    </div>
</div>
<!-- 操作列 -->
<script type="text/html" id="operate-state">
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="edit">修改</a>
    {{#  if(d.user_id != 1){ }}
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    {{#  } }}
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="resetPwd">重置密码</a>
    {{#  if(d.user_id != 1){ }}
    {{#  if(d.user_status == 1){ }}
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="forbid">禁用</a>
    {{#  } else { }}
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="reuse">启用</a>
    {{#  } }}
    {{#  } }}
</script>
<script type="text/javascript" src="/static/layuiadmin/layui/layui.js"></script><script type="text/javascript" src="/static/js/tools.js"></script>
<script>
    var tableIns;
    layui.config({
        base: '/static/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table'], function(){
        var $ = layui.$,
            form = layui.form,
            table = layui.table;
        // 搜索框的高度
        var search_form_h = $("#search-form").height();
        var fullSub = search_form_h > 50 ? '215': '175'; //table需要减去的高度
        //
        layer.load(1);
        tableIns = table.render({
            elem: '#layui-datatables',
            url: '<?php echo url("admin/adminuser/index"); ?>',
            method: 'post',
            page: true,
            loading: true,
            limit: 20,
            height: 'full-' + fullSub,
            cols: [[
                {type: 'numbers'},
                {field: 'user_nickname', minWidth: 120, title: '用户昵称'},
                {field: 'user_username', minWidth: 120, title: '登录账号'},
                {field: 'user_role_string', minWidth: 120, title: '用户角色'},
                {field: 'user_status', width: 100,  title: '状态', align: 'center', templet: function (d) {
                    // 显示的名称
                    var _name = "";
                    if("1" == d.user_status){
                        _name = "正常";
                    }
                    if("0" == d.user_status){
                        _name = "冻结";
                    }
                    // 显示的颜色
                    var _css = "";
                    if (d.user_status == 1) {
                        _css = "layui-bg-green";
                    } else {
                        _css = "layui-bg-red";
                    }
                    //返回值
                    return '<span class="layui-badge ' + _css + '">' + _name + '</span>';
                }
                },
                {field: 'user_create_time', width: 120, align: 'center', title: '创建日期', templet: function(d) {
                    return new Date(d.user_create_time*1000).Format("yyyy-MM-dd");
                }},
                {field: 'user_login_time', width: 170, align: 'center', title: '最近登录', templet: function(d) {
                    return new Date(d.user_login_time*1000).Format("yyyy-MM-dd");
                }},
                {templet: '#operate-state', width: 250, align: 'center', title: '操作', fixed: 'right'}
            ]],
            done: function () {
                layer.closeAll('loading');
            }
        });
        // 新增事件
        $('#btn-add').click(function () {
            layer.open({
                type: 2,
                title: '新增管理员',
                content: '<?php echo url("admin/adminuser/updateadd"); ?>',
                area: layerArea2(), //计算页面大小
            });
        });
        //监听搜索
        form.on('submit(layui-datatables-search)', function(data){
            var field = data.field;
            layer.load(1);
            //执行重载
            table.reload('layui-datatables', {
                where: field,
                page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
            return false;
        });
        //监听单元格事件
        table.on('tool(layui-datatables)', function(obj){
            var data = obj.data;
            var layEvent = obj.event;
            // 处理事件
            if (layEvent == "forbid") { // 禁用
                layer.confirm('你确定要禁用该账号?', {icon: 3, title:'提示'}, function(index){
                    layer.load(1);
                    $.post("<?php echo url('admin/adminuser/status'); ?>",{uid:data.user_id, type: "forbid"}, function(result){
                        layer.close(index);
                        layer.closeAll('loading');
                        if (result.code == 0) {
                            tableIns.reload();
                            layer.msg("操作成功",{icon: 1});
                        } else {
                            layer.msg(result.msg,{icon: 2});
                        }
                    },"json");
                });
            } else if (layEvent == "reuse") { // 启用
                layer.confirm('你确定要启用该账号?', {icon: 3, title:'提示'}, function(index){
                    layer.load(1);
                    $.post("<?php echo url('admin/adminuser/status'); ?>",{uid:data.user_id, type: "reuse"}, function(result){
                        layer.close(index);
                        layer.closeAll('loading');
                        if (result.code == 0) {
                            tableIns.reload();
                            layer.msg("操作成功",{icon: 1});
                        } else {
                            layer.msg(result.msg,{icon: 2});
                        }
                    },"json");
                });
            } else if (layEvent == "del") { // 删除
                layer.confirm('你确定要删除该账号?', {icon: 3, title:'提示'}, function(index){
                    layer.load(1);
                    $.post("<?php echo url('admin/adminuser/status'); ?>",{uid:data.user_id, type: "del"}, function(result){
                        layer.close(index);
                        layer.closeAll('loading');
                        if (result.code == 0) {
                            tableIns.reload();
                            layer.msg("操作成功",{icon: 1});
                        } else {
                            layer.msg(result.msg,{icon: 2});
                        }
                    },"json");
                });
            } else if (layEvent == "edit") {
                layer.open({
                    type: 2,
                    title: '修改用户信息',
                    content: '<?php echo url("admin/adminuser/updateadd"); ?>?uid=' + data.user_id,
                    area: layerArea2(), //计算页面大小
                });
            } else if (layEvent == "resetPwd") {
                layer.prompt({title: '请输入新的登录密码', formType: 1}, function(newPwd, index){
                    layer.load(1);
                    $.post("<?php echo url('admin/adminuser/resetpwd'); ?>",{uid: data.user_id,newPwd:newPwd}, function(result){
                        layer.close(index);
                        layer.closeAll('loading');
                        if (result.code == 0) {
                            layer.msg("重置登录密码成功",{icon: 1});
                        } else {
                            layer.msg(result.msg,{icon: 2});
                        }
                    },"json");
                });
            }
        });
    });
</script>
</body>
</html>