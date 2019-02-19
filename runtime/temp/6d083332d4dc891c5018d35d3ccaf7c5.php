<?php /*a:1:{s:63:"D:\Timount\mall\application\admin\view\adminauth\addupdate.html";i:1539228170;}*/ ?>
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
    <!-- 下面是定义通用的变量信息 -->
    <link rel="stylesheet" type="text/css" href="/static/layuiadmin/layui/css/layui.css" /><link rel="stylesheet" type="text/css" href="/static/layuiadmin/style/admin.css" />
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <title></title>
</head>
<body>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form" action="" lay-filter="layui-business-form">
                <input type="hidden" name="id" value="<?php if(!(empty($info['auth_id']) || (($info['auth_id'] instanceof \think\Collection || $info['auth_id'] instanceof \think\Paginator ) && $info['auth_id']->isEmpty()))): ?><?php echo htmlentities($info['auth_id']); else: ?>0<?php endif; ?>"/>
                <div class="layui-form-item layui-row">
                    <div class="layui-col-md6">
                        <label class="layui-form-label"><span class="required">*</span>菜单名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" lay-verify="required" lay-vertype="tips" autocomplete="off" placeholder="请输入菜单名称" class="layui-input" value="<?php if(!(empty($info['auth_name']) || (($info['auth_name'] instanceof \think\Collection || $info['auth_name'] instanceof \think\Paginator ) && $info['auth_name']->isEmpty()))): ?><?php echo htmlentities($info['auth_name']); ?><?php endif; ?>">
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <label class="layui-form-label">菜单链接</label>
                        <div class="layui-input-block">
                            <input type="text" name="url" autocomplete="off" placeholder="请输入菜单链接" class="layui-input" value="<?php if(!(empty($info['auth_url']) || (($info['auth_url'] instanceof \think\Collection || $info['auth_url'] instanceof \think\Paginator ) && $info['auth_url']->isEmpty()))): ?><?php echo htmlentities($info['auth_url']); ?><?php endif; ?>">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item layui-row">
                    <div class="layui-col-md6">
                        <label class="layui-form-label">父级菜单</label>
                        <div class="layui-input-block">
                            <select name="pid">
                                <option value=""></option>
                                <?php if(is_array($father) || $father instanceof \think\Collection || $father instanceof \think\Paginator): $i = 0; $__LIST__ = $father;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$father): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo htmlentities($father['auth_id']); ?>" <?php if(!(empty($info['auth_id']) || (($info['auth_id'] instanceof \think\Collection || $info['auth_id'] instanceof \think\Paginator ) && $info['auth_id']->isEmpty()))): if($info['auth_pid'] == $father['auth_id']): ?>selected<?php endif; ?><?php endif; ?>><?php echo htmlentities($father['auth_name']); ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <label class="layui-form-label">菜单图标</label>
                        <div class="layui-input-block">
                            <input type="text" name="icon" autocomplete="off" placeholder="不需要填写" class="layui-input" value="<?php if(!(empty($info['auth_icon']) || (($info['auth_icon'] instanceof \think\Collection || $info['auth_icon'] instanceof \think\Paginator ) && $info['auth_icon']->isEmpty()))): ?><?php echo htmlentities($info['auth_icon']); ?><?php endif; ?>">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item layui-row">
                    <div class="layui-col-md6">
                        <label class="layui-form-label"><span class="required">*</span>菜单状态</label>
                        <div class="layui-input-block">
                            <?php if(!(empty($info['auth_id']) || (($info['auth_id'] instanceof \think\Collection || $info['auth_id'] instanceof \think\Paginator ) && $info['auth_id']->isEmpty()))): ?>
                            <input type="radio" name="type" value="1" title="显示" <?php if($info['auth_menu_status'] == 1): ?>checked<?php endif; ?>>
                            <input type="radio" name="type" value="0" title="隐藏" <?php if($info['auth_menu_status'] == 0): ?>checked<?php endif; ?>>
                            <?php else: ?>
                            <input type="radio" name="type" value="1" title="显示" checked="checked">
                            <input type="radio" name="type" value="0" title="隐藏" >
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <label class="layui-form-label"><span class="required">*</span>显示序号</label>
                        <div class="layui-input-block">
                            <input type="text" name="orderIndex" lay-verify="required|number" lay-vertype="tips" autocomplete="off" placeholder="" class="layui-input" value="<?php if(!(empty($info['auth_sort']) || (($info['auth_sort'] instanceof \think\Collection || $info['auth_sort'] instanceof \think\Paginator ) && $info['auth_sort']->isEmpty()))): ?><?php echo htmlentities($info['auth_sort']); else: ?>99<?php endif; ?>">
                        </div>
                    </div>
                </div>

                <!-- 提交 -->
                <div class="layui-form-item layui-layout-admin">
                    <div class="layui-input-block">
                        <div class="layui-footer" style="left: 0;">
                            <button class="layui-btn" lay-submit="" lay-filter="layui-business-submit">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/layuiadmin/layui/layui.js"></script><script type="text/javascript" src="/static/js/tools.js"></script>
<script>
    layui.config({
        base: '/static/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form', 'laydate'], function(){
        var $ = layui.$
            ,form = layui.form;
        /* 监听提交 */
        form.on('submit(layui-business-submit)', function(data){
            layer.load(1);
            $.post('<?php echo url("admin/adminauth/addupdate"); ?>',data.field,function(result){
                layer.closeAll('loading');
                if (result.code == 0) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.renderTable();
                    parent.layer.msg("操作成功",{icon: 1});
                } else {
                    layer.msg(result.msg,{icon: 2});
                }
            },"json");
            return false;
        });
    });
</script>
</body>
</html>